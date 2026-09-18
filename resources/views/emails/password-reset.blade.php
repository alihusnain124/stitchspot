<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reset your password</title>
</head>
<body style="margin:0;padding:0;background:#F5F4F2;font-family:'DM Sans',Helvetica,Arial,sans-serif;">
   <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F5F4F2;padding:32px 16px;">
      <tr>
         <td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                   style="max-width:520px;background:#ffffff;box-shadow:0 4px 32px rgba(0,0,0,.06);">
               <tr>
                  <td style="padding:36px 40px 0;">
                     <div style="font-family:Georgia,serif;font-size:26px;font-weight:600;color:#1A1A1A;">
                        Stitch<span style="color:#C9A96E;">Spot</span>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td style="padding:28px 40px 0;">
                     <h1 style="margin:0 0 14px;font-family:Georgia,serif;font-size:30px;font-weight:600;color:#1A1A1A;line-height:1.15;">
                        Reset your password
                     </h1>
                     <p style="margin:0 0 18px;font-size:14px;line-height:1.65;color:#666;">
                        @if($name) Hi {{ $name }}, @else Hello, @endif
                        we received a request to reset the password on your StitchSpot account.
                        Click the button below to choose a new one.
                     </p>
                  </td>
               </tr>
               <tr>
                  <td style="padding:10px 40px 0;">
                     <a href="{{ $resetUrl }}"
                        style="display:inline-block;background:#1A1A1A;color:#ffffff;text-decoration:none;
                               font-size:11px;letter-spacing:.22em;text-transform:uppercase;padding:15px 30px;">
                        Reset Password
                     </a>
                  </td>
               </tr>
               <tr>
                  <td style="padding:26px 40px 0;">
                     <p style="margin:0 0 10px;font-size:13px;line-height:1.65;color:#888;">
                        This link expires in 60 minutes and can only be used once.
                     </p>
                     <p style="margin:0 0 10px;font-size:13px;line-height:1.65;color:#888;">
                        If you didn't ask for this, you can safely ignore this email &mdash;
                        your password will stay as it is.
                     </p>
                  </td>
               </tr>
               <tr>
                  <td style="padding:22px 40px 36px;">
                     <p style="margin:0 0 6px;font-size:11px;color:#aaa;">
                        If the button doesn't work, paste this into your browser:
                     </p>
                     <p style="margin:0;font-size:11px;color:#C9A96E;word-break:break-all;">
                        {{ $resetUrl }}
                     </p>
                  </td>
               </tr>
            </table>
            <p style="margin:18px 0 0;font-size:11px;color:#aaa;letter-spacing:.12em;text-transform:uppercase;">
               StitchSpot &mdash; Fashion &amp; Tailoring
            </p>
         </td>
      </tr>
   </table>
</body>
</html>
