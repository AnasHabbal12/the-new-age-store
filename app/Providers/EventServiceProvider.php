<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\DepuctProductQuantity;
use App\Listeners\SendOrderCreatedNotification;
use App\Listeners\EmpetyCart;
use App\Events\OrderCreated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // 'order.created' => [
        //     DepuctProductQuantity::class,
        //     EmpetyCart::class,
        // ],
        OrderCreated::class => [
            DepuctProductQuantity::class,
            SendOrderCreatedNotification::class,
            //EmpetyCart::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
