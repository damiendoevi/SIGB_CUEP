<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LateReaderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $name = $notifiable->lastname." ".$notifiable->firstname;
        return (new MailMessage)
            ->subject('Retour des ressources empruntées')
            ->cc('adaniel@gouv.bj')
            ->greeting('Cher(e) ' . $name . ',')
            ->line('Nous vous rappelons de bien vouloir retourner à temps les ressources que vous avez empruntées à la bibliothèque. Le dépassement de la date de retour peut entraîner des pénalités ou des restrictions d\'emprunt')
            ->line('Merci de vous rendre à la bibliothèque dès que possible pour effectuer le retour des ressources empruntées.')
            ->salutation('Cordialement, ' . config('app.name'));
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
