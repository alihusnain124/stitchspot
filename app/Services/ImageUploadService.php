<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Stores uploaded images on the public disk, downscaling and re-encoding them
 * first so the originals straight off a phone camera do not get served to
 * visitors as-is.
 *
 * Callers keep the existing convention of persisting only the file name; the
 * directory is re-applied when the view builds the URL.
 */
class ImageUploadService
{
    /** Longest edge kept, in pixels. Larger images are scaled down to fit. */
    public const MAX_EDGE = 1600;

    /** Re-encode quality for lossy formats. */
    public const QUALITY = 82;

    /** Extensions accepted by the uploader, mapped from the detected MIME type. */
    protected const ALLOWED = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];

    /**
     * Store an upload and return the generated file name.
     *
     * Passing $replacing deletes the previous file once the new one is safely
     * written, so a failed upload never leaves the record pointing at nothing.
     */
    public function store(UploadedFile $file, string $dir, ?string $replacing = null): string
    {
        $mime = $file->getMimeType();

        if (! isset(self::ALLOWED[$mime])) {
            throw new \RuntimeException('Unsupported image type: '.$mime);
        }

        $ext = self::ALLOWED[$mime];
        $name = Str::uuid()->toString().'.'.$ext;
        $dir = trim($dir, '/');

        $encoded = $this->optimise($file, $mime, $ext);

        Storage::disk('public')->put($dir.'/'.$name, $encoded, 'public');

        if ($replacing) {
            $this->delete($replacing, $dir);
        }

        return $name;
    }

    /**
     * Delete a previously stored file, ignoring names that were never set.
     *
     * Old records sometimes hold a full URL rather than a file name; those are
     * remote and must be left alone.
     */
    public function delete(?string $name, string $dir): void
    {
        if (! $name || Str::startsWith($name, ['http://', 'https://'])) {
            return;
        }

        $path = trim($dir, '/').'/'.basename($name);

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Downscale and re-encode the image, returning the raw bytes to write.
     *
     * Animated GIFs are passed through untouched, since re-encoding one through
     * GD would flatten it to a single frame.
     */
    protected function optimise(UploadedFile $file, string $mime, string $ext): string
    {
        $path = $file->getRealPath();

        if ($ext === 'gif') {
            return file_get_contents($path);
        }

        $source = match ($mime) {
            'image/jpeg' => @imagecreatefromjpeg($path),
            'image/png' => @imagecreatefrompng($path),
            'image/webp' => @imagecreatefromwebp($path),
        };

        if (! $source) {
            throw new \RuntimeException('The image could not be read.');
        }

        $source = $this->applyExifOrientation($source, $path, $mime);

        $width = imagesx($source);
        $height = imagesy($source);
        $scale = min(1, self::MAX_EDGE / max($width, $height));

        if ($scale < 1) {
            $target = imagecreatetruecolor((int) round($width * $scale), (int) round($height * $scale));
            $this->preserveTransparency($target, $ext);

            imagecopyresampled(
                $target, $source,
                0, 0, 0, 0,
                imagesx($target), imagesy($target), $width, $height
            );

            imagedestroy($source);
            $source = $target;
        }

        ob_start();

        match ($ext) {
            'jpg' => imagejpeg($source, null, self::QUALITY),
            'png' => imagepng($source, null, 8),
            'webp' => imagewebp($source, null, self::QUALITY),
        };

        $bytes = ob_get_clean();
        imagedestroy($source);

        return $bytes;
    }

    /**
     * Keep PNG and WebP alpha channels intact through the resize.
     */
    protected function preserveTransparency(\GdImage $target, string $ext): void
    {
        if ($ext === 'png' || $ext === 'webp') {
            imagealphablending($target, false);
            imagesavealpha($target, true);
            imagefill($target, 0, 0, imagecolorallocatealpha($target, 0, 0, 0, 127));
        }
    }

    /**
     * Rotate JPEGs that carry an EXIF orientation flag, so photos taken on a
     * phone are not stored sideways.
     */
    protected function applyExifOrientation(\GdImage $image, string $path, string $mime): \GdImage
    {
        if ($mime !== 'image/jpeg' || ! function_exists('exif_read_data')) {
            return $image;
        }

        $exif = @exif_read_data($path);
        $orientation = $exif['Orientation'] ?? 1;

        $angle = match ($orientation) {
            3 => 180,
            6 => -90,
            8 => 90,
            default => 0,
        };

        if ($angle === 0) {
            return $image;
        }

        $rotated = imagerotate($image, $angle, 0);
        imagedestroy($image);

        return $rotated;
    }
}
