<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\URL;

class CustomResetPassword extends ResetPassword
{
    protected function resetUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(config('auth.passwords.'.config('auth.defaults.passwords').'.expire', 60)),
            [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]
        );
    }
}