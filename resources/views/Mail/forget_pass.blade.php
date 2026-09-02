<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f9; font-family: Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f9; padding: 40px 0;">
        <tr>
            <td align="center">

                {{-- Email Card --}}
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

                    {{-- Header --}}
                    <tr>
                        <td style="background-color:#ff6b35; padding: 40px 0; text-align:center;">
                            <h1 style="margin:0; color:#ffffff; font-size:28px; font-weight:700; letter-spacing:1px;">
                                🛒 My Store
                            </h1>
                            <p style="margin:8px 0 0; color:#ffe0d3; font-size:14px;">
                                Your favourite online shopping destination
                            </p>
                        </td>
                    </tr>

                    {{-- Banner --}}
                    <tr>
                        <td style="background-color:#fff5f2; padding: 20px 50px; text-align:center; border-bottom: 1px solid #ffe0d3;">
                            <p style="margin:0; font-size:13px; color:#ff6b35; font-weight:600; letter-spacing:0.5px;">
                                🔐 ACCOUNT SECURITY
                            </p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 40px 50px;">

                            <h2 style="margin:0 0 16px; color:#1a1a2e; font-size:22px;">
                                Reset Your Password
                            </h2>

                            <p style="margin:0 0 16px; color:#555555; font-size:15px; line-height:1.7;">
                                Hi there 👋, we received a request to reset the password for your
                                <strong>My Store</strong> account. No worries — it happens to the best of us!
                            </p>

                            <p style="margin:0 0 30px; color:#555555; font-size:15px; line-height:1.7;">
                                Click the button below to choose a new password. This link will expire in
                                <strong>60 minutes</strong>.
                            </p>

                            {{-- Button --}}
                            <table cellpadding="0" cellspacing="0" style="margin: 0 auto 30px;">
                                <tr>
                                    <td style="background-color:#ff6b35; border-radius:6px; text-align:center;">
                                        <a href="{{ $data }}"
                                           style="display:inline-block; padding:14px 40px; color:#ffffff;
                                                  font-size:15px; font-weight:700; text-decoration:none;
                                                  letter-spacing:0.5px;">
                                            Reset My Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            {{-- Warning box --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                                <tr>
                                    <td style="background-color:#fff8f0; border-left:4px solid #ff6b35;
                                               border-radius:4px; padding:14px 18px;">
                                        <p style="margin:0; color:#cc4400; font-size:13px; line-height:1.6;">
                                            ⚠️ If you did <strong>not</strong> request a password reset,
                                            please ignore this email. Your account is safe and no changes have been made.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Fallback link --}}
                            <p style="margin:0; color:#888888; font-size:13px; line-height:1.6;">
                                Button not working? Copy and paste this link into your browser:
                            </p>
                            <p style="margin:6px 0 0; word-break:break-all;">
                                <a href="{{ $data }}" style="color:#ff6b35; font-size:13px;">{{ $data }}</a>
                            </p>

                        </td>
                    </tr>

                    {{-- Divider --}}
                    <tr>
                        <td style="padding: 0 50px;">
                            <hr style="border:none; border-top:1px solid #eeeeee; margin:0;">
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding: 24px 50px; text-align:center;">
                            <p style="margin:0 0 8px; color:#aaaaaa; font-size:12px;">
                                Need help?
                                <a href="#" style="color:#ff6b35; text-decoration:none;">Contact Support</a>
                            </p>
                            <p style="margin:0; color:#aaaaaa; font-size:12px; line-height:1.6;">
                                © {{ date('Y') }} My Store. All rights reserved.<br>
                                This is an automated email — please do not reply.
                            </p>
                        </td>
                    </tr>

                </table>
                {{-- End Card --}}

            </td>
        </tr>
    </table>

</body>
</html>
