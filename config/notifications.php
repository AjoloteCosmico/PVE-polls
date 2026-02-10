<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Notification Channels
    |--------------------------------------------------------------------------
    |
    | This file defines the available notification channels for your application.
    |
    */

    'channels' => [
        'mail' => \Illuminate\Notifications\Channels\MailChannel::class,
        'database' => \Illuminate\Notifications\Channels\DatabaseChannel::class,
        'broadcast' => \Illuminate\Notifications\Channels\BroadcastChannel::class,
        'array' => \Illuminate\Notifications\Channels\ArrayChannel::class,
        'nexmo' => \Illuminate\Notifications\Channels\NexmoSmsChannel::class,
        'slack' => \Illuminate\Notifications\Channels\SlackChannel::class,
    ],
];