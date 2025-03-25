<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PointRedemptionStatusNotification extends Notification
{
    use Queueable;

    protected $transaction;
    protected $status;

    /**
     * Create a new notification instance.
     *
     * @param  mixed  $transaction
     * @param  string  $status
     * @return void
     */
    public function __construct($transaction, $status)
    {
        $this->transaction = $transaction;
        $this->status = $status;
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
            ->subject('Point Redemption Status Update')
            ->line("Your redemption for '{$this->transaction->product->name}' has been updated.")
            ->line("New status: " . ucfirst($this->status))
            ->action('View Details', url('/point'))
            ->line('Thank you for using our application!');
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
            'message' => "Your redemption for '{$this->transaction->product->name}' is now '{$this->status}'.",
            'transaction_id' => $this->transaction->id,
            'status' => $this->status,
        ];
    }
}
