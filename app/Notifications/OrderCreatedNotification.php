<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Order;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];

        $channels = ['database'];
        if ($notifiable->notification['order_created']['sms'] ?? false)
        {
            $channels[] = 'vonage';
        }
        if ($notifiable->notification['order_created']['mail'] ?? false)
        {
            $channels[] = 'mail';
        }
        if ($notifiable->notification['order_created']['broadcast'] ?? false)
        {
            $channels[] = 'broadcast';
        }
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $addr = $this->order->billingAdress;
        return (new MailMessage)
                    ->subject('New Order #'. $this->order->number)
                    ->greeting('helo'. $notifiable->name)
                    ->line('A new order has been created by '. $addr->full_name . 'from ' . $addr->country_name )
                    ->action('View Order', url('/dashboard'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase(object $notifiable) {
        $addr = $this->order->billingAdress;
        return [
            'body' => 'order created by '. $addr->full_name . 'from ' . $addr->country_name,
            'icon' => 'fas fa-file',
            'url' => url('/dashboard'),
            'order_id' => $this->order->id,
        ];
    }

    public function toBroadcast(object $notifiable) {
        $addr = $this->order->billingAdress;
        return  new BroadcastMessage( [
            'body' => 'order created by '. $addr->full_name . 'from ' . $addr->country_name,
            'icon' => 'fas fa-file',
            'url' => url('/dashboard'),
            'order_id' => $this->order->id,
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
