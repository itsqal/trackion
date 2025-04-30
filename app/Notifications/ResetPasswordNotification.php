<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $token)
    {
        //
    }

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
        $resetUrl = url(config('app.url') . route('password.reset', $this->token, false));

        return (new MailMessage)
            ->subject('🔒 Atur Ulang Kata Sandi Anda')
            ->greeting('Halo,')
            ->line('Kami menerima permintaan untuk mengatur ulang kata sandi Anda.')
            ->action('Atur Ulang Kata Sandi', $resetUrl)
            ->line('Jika Anda tidak meminta pengaturan ulang kata sandi, abaikan email ini.');
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
