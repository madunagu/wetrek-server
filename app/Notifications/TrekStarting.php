<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Trek;

class TrekStarting extends Notification implements ShouldQueue
{
    use Queueable;

    private Trek $trek;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($trek)
    {
        $this->trek = $trek;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
            ->line($this->trek->name . ' Is Starting Soon')
            ->line($this->trek->name . ' Scheduled to take place at ' . $this->trek->starting_at . ' is starting soon')
            // ->line('Trek starts from'. $this->trek->starting_at. ' is starting soon')
            // ->action($this->offerData['offerText'], $this->offerData['offerUrl'])
            ->line('thanks');
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
