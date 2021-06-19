<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class TemporalPassword extends Notification
{
    use Queueable;

    private User $user;
    private string $temporalPassword;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, string $temporalPassword)
    {
        $this->user = $user;
        $this->temporalPassword = $temporalPassword;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Stroney - Contraseña temporal')
            ->greeting("Hola {$this->user->name},")
            ->line('Te compartimos una contraseña temporal para que puedas acceder')
            ->line(new HtmlString("<strong>$this->temporalPassword</strong>"))
            ->line('Muchas gracias por ser parte de nuestra comunidad');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
