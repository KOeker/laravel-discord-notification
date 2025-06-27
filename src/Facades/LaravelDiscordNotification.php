<?php

declare(strict_types=1);

namespace Koeker\LaravelDiscordNotification\Facades;

use Illuminate\Support\Facades\Facade;
use Koeker\LaravelDiscordNotification\DiscordNotification;

/**
 * @method static DiscordNotification setWebhookAgent(string $webhook, ?string $username = null, ?string $avatarUrl = null)
 * @method static DiscordNotification setWebhookAgentSafe(string $webhook, ?string $username = null, ?string $customAvatarUrl = null)
 * @method static bool sendNotification(DiscordNotification $notification)
 * @method static bool send(string $webhook, array $data)
 *
 * @see \Koeker\LaravelDiscordNotification\DiscordWebhookService
 */
class LaravelDiscordNotification extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'discord-webhook';
    }
}
