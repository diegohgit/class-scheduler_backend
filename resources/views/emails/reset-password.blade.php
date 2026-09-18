<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset your password</title>
</head>

<div style="margin:0; padding:0; background:#f5f5f5;">

    <div style="
        max-width:600px;
        margin:40px auto;
        background:white;
        padding:40px;
        font-family:Arial,sans-serif;
        color:#364153;
    ">

        <h1 style="margin-top:0;">
            Reset your password
        </h1>

        <p>Hello {{ $user->name }},</p>

        <p>We received a request to reset the password of your <b>Class Scheduler</b> account.</p>
        <p>Click the following button to create a new password:</p>

        <p style="text-align: center;">
            <a href="{{ $url }}"
               style="display:inline-block;
                      padding:12px 24px;
                      background:#364153;
                      color:white;
                      text-decoration:none;
                      border-radius:6px;"
            >
                Reset Password
            </a>
        </p>

        <p>This password reset link will expire soon.</p>
        <p>If you didn't request this, you can safely ignore this email.</p>

        <p>
            Regards,<br>
            {{ config('app.name') }}
        </p>
    </div>
</div>
</html>