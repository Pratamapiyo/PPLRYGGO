<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusUpdateNotification extends Notification
{
    use Queueable;

    protected $ecoCycle;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ecoCycle)
    {
        $this->ecoCycle = $ecoCycle;
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
                    ->line('Status pengambilan sampah Anda telah diperbarui.')
                    ->line('Status baru: ' . ucfirst($this->ecoCycle->status))
                    ->action('Lihat Detail', url('/ecocycle/' . $this->ecoCycle->id))
                    ->line('Terima kasih telah menggunakan aplikasi kami!');
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
            'message' => 'Status pengambilan sampah Anda telah diperbarui menjadi: ' . ucfirst($this->ecoCycle->status),
            'ecoCycleId' => $this->ecoCycle->id,
        ];
    }
}