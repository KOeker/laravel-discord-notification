<?php

declare(strict_types=1);

namespace Koeker\LaravelDiscordNotification;

use Illuminate\Support\ServiceProvider;

class DiscordWebhookServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('discord-webhook', function () {
            return new DiscordWebhookService();
        });
    }

}
