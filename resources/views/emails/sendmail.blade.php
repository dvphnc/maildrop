<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message from {{ $data['name'] }}</title>
</head>
<body style="margin:0; padding:0; background-color:#121212; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;">

    <!-- Wrapper -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#121212; padding: 40px 16px;">
        <tr>
            <td align="center">

                <!-- Card -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:520px; background-color:#181818; border-radius:16px; overflow:hidden; border:1px solid rgba(255,255,255,0.07);">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1a3d2b 0%, #121212 80%); padding: 40px 36px 32px; text-align:center; border-bottom: 1px solid rgba(255,255,255,0.06);">

                            <!-- Logo circle -->
                            <div style="width:56px; height:56px; background:#1DB954; border-radius:50%; margin: 0 auto 20px; display:flex; align-items:center; justify-content:center;">
                                <img src="https://img.icons8.com/ios-filled/50/000000/new-post.png" width="26" height="26" alt="mail" style="display:block; margin: auto; padding-top: 14px;"/>
                            </div>

                            <p style="margin:0 0 6px; font-size:12px; font-weight:600; letter-spacing:0.15em; text-transform:uppercase; color:#1DB954;">New Message</p>
                            <h1 style="margin:0; font-size:24px; font-weight:700; color:#ffffff; letter-spacing:-0.5px;">
                                {{ $data['name'] }}
                            </h1>
                            <p style="margin: 8px 0 0; font-size:13px; color:#a7a7a7;">sent you a message</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 32px 36px;">

                            <!-- From -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;">
                                <tr>
                                    <td style="background:#282828; border-radius:10px; padding:14px 18px;">
                                        <p style="margin:0 0 4px; font-size:10px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:#a7a7a7;">From</p>
                                        <p style="margin:0; font-size:14px; color:#1DB954; font-weight:500;">{{ $data['email'] }}</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Divider label -->
                            <p style="margin:0 0 12px; font-size:10px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:#a7a7a7;">Message</p>

                            <!-- Message box -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px;">
                                <tr>
                                    <td style="background:#282828; border-radius:10px; padding:18px; border-left: 3px solid #1DB954;">
                                        <p style="margin:0; font-size:15px; color:#e0e0e0; line-height:1.7;">
                                            {{ $data['message'] }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Divider -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:28px;">
                                <tr>
                                    <td style="border-top: 1px solid rgba(255,255,255,0.07); font-size:0; line-height:0;">&nbsp;</td>
                                </tr>
                            </table>

                            <!-- Footer note -->
                            <p style="margin:0; font-size:12px; color:#555; text-align:center; line-height:1.6;">
                                This email was sent via <span style="color:#1DB954; font-weight:600;">MailDrop</span> &mdash; powered by Laravel &amp; Gmail SMTP.
                            </p>

                        </td>
                    </tr>

                    <!-- Bottom bar -->
                    <tr>
                        <td style="background:#101010; padding:16px 36px; text-align:center; border-top:1px solid rgba(255,255,255,0.05);">
                            <p style="margin:0; font-size:11px; color:#3a3a3a; letter-spacing:0.05em;">
                                &copy; {{ date('Y') }} MailDrop. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
                <!-- /Card -->

            </td>
        </tr>
    </table>

</body>
</html>