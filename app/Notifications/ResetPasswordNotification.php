<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
//use function urlencode; // Add this line

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private string $token
    ){}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        //Build url using token and user's email.
        $url =  config('app.frontend_url')//app.frontend_url is taken from confign/app.php
                .'/reset-password?token='
                .urlencode($this->token)
                .'&email='
                .urlencode($notifiable->email);

        //Build email content.
        return (new MailMessage)
            ->subject('Class Scheduler: Reset your password')
            ->view('emails.reset-password',[
                'url' => $url,
                'user' => $notifiable
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
