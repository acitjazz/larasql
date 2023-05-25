<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        'App\Events\InvoiceEvent' => [
            'App\Listeners\SyncEvent',
        ],
        'App\Events\BillingFeedbackEvent' => [
            'App\Listeners\CreateFeedbackBilling',
        ],
        'App\Events\OrderTrackerFeedbackEvent' => [
            'App\Listeners\CreateFeedbackOrderTracker',
        ],
        'App\Events\ServiceFeedbackEvent' => [
            'App\Listeners\CreateFeedbackService',
        ],
        'App\Events\TicketFeedbackEvent' => [
            'App\Listeners\CreateFeedBackTicket',
            'App\Listeners\PointTicket',
        ],
        'App\Events\LogEvent' => [
            'App\Listeners\SaveLog',
        ],
        'App\Events\EventPoint' => [
            'App\Listeners\SavePoint',
            'App\Listeners\SendApiFeedback',
        ],
        'App\Events\FeedbackAreaEvent' => [
            'App\Listeners\FeedbackAreaSave',
            // 'App\Listeners\SendApiFeedback',
        ],
        'App\Events\SendFeedbackApiEvent' => [
            'App\Listeners\SendFeedBackApi',
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
