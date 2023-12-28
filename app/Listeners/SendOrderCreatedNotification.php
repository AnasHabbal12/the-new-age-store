<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminamte\Support\Facades\Notification;

class SendOrderCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        //$store = $event->order->store;
        $user = User::where('store_id', $event->order->store_id)->first() ?? User::where('store_id', 6)->first();

        //dd($user);
        $user->notify(new OrderCreatedNotification($event->order));

        //$users = User::where('store_id', $event->order->store_id)->get();
        // way 1 to send many users
        // foreach($users as $us) {
        //     $us->notify(new OrderCreatedNotification($event->order));
        // way 2 to send many users
        //Notification::send($users, new OrderCreatedNotification($event->order));
    }
}
