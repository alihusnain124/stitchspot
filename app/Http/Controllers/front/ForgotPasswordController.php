<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Mail\CustomerPasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * Password reset for storefront customers.
 *
 * The site authenticates customers itself rather than through a Laravel guard
 * (see FrontController::login_process), so Laravel's password broker cannot be
 * used here. This mirrors what the broker does, against the customers table.
 */
class ForgotPasswordController extends Controller
{
    /** How long a reset link stays valid, in minutes. */
    protected const EXPIRES = 60;

    /** How long a customer must wait before requesting another link, in seconds. */
    protected const THROTTLE = 60;

    public function showRequestForm()
    {
        return view('front.forgot-password');
    }

    /**
     * Issue a reset link.
     *
     * The response is deliberately identical whether or not the address is
     * registered, so this cannot be used to discover which emails have accounts.
     */
    public function sendResetLink(Request $req)
    {
        $req->validate(['email' => 'required|email']);

        $email = $req->input('email');
        $generic = 'If that email is registered, a reset link is on its way.';

        $customer = DB::table('customers')->where('email', $email)->first();

        if (! $customer) {
            return back()->with('status', $generic)->with('status_title', 'Check your email');
        }

        $existing = DB::table('password_resets')->where('email', $email)->first();

        if ($existing && Carbon::parse($existing->created_at)->addSeconds(self::THROTTLE)->isFuture()) {
            return back()->with('status', $generic)->with('status_title', 'Check your email');
        }

        $token = Str::random(64);

        // Only the hash is stored, so a leaked table cannot be used to reset accounts.
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        try {
            Mail::to($email)->send(new CustomerPasswordReset(
                $customer->name ?? '',
                route('password.reset', ['token' => $token]).'?email='.urlencode($email)
            ));
        } catch (\Throwable $e) {
            // Don't leak mail-transport problems to the visitor, but make sure
            // they are visible to whoever is looking after the site.
            Log::error('Password reset mail failed: '.$e->getMessage());

            return back()->withErrors(['email' => 'We could not send the email just now. Please try again shortly.']);
        }

        return back()->with('status', $generic)->with('status_title', 'Check your email');
    }

    public function showResetForm(Request $req, string $token)
    {
        return view('front.reset-password', [
            'token' => $token,
            'email' => $req->query('email', ''),
        ]);
    }

    public function reset(Request $req)
    {
        $req->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'string',
                'min:8',
                'regex:/[a-zA-Z]/',
                'regex:/[0-9]/',
            ],
        ], [
            'password.regex' => 'The password must contain at least one letter and one number.',
        ]);

        $record = DB::table('password_resets')->where('email', $req->input('email'))->first();

        $invalid = ! $record
            || ! Hash::check($req->input('token'), $record->token)
            || Carbon::parse($record->created_at)->addMinutes(self::EXPIRES)->isPast();

        if ($invalid) {
            return back()->withErrors(['email' => 'This reset link is invalid or has expired. Please request a new one.']);
        }

        DB::table('customers')
            ->where('email', $req->input('email'))
            ->update([
                'password' => Hash::make($req->input('password')),
                'updated_at' => now(),
            ]);

        // The link is single-use.
        DB::table('password_resets')->where('email', $req->input('email'))->delete();

        return redirect('/login')
            ->with('status', 'Your password has been updated. You can sign in now.')
            ->with('status_title', 'Password updated');
    }
}
