<?php

declare(strict_types=1);

namespace Koeker\LaravelDiscordNotification;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class DiscordWebhookService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'headers' => [
                'Content-Type' => 'application/json',
                'User-Agent' => 'Laravel Discord Webhook'
            ]
        ]);
    }

    public static function setWebhookAgent(
        string $webhook,
        ?string $username = null,
        ?string $avatarUrl = null
    ): DiscordNotification
    {
        $notification = new DiscordNotification($webhook);

        if ($username) {
            $notification->setUsername($username);
        }

        if ($avatarUrl) {
            $notification->setAvatarUrl($avatarUrl);
        }

        return $notification;
    }

    public static function sendNotification(DiscordNotification $notification): bool
    {
        return (new static())->send($notification->getWebhook(), $notification->getData());
    }

    public function sendNotificationInstance(DiscordNotification $notification): bool
    {
        try {
            $response = $this->client->post($notification->getWebhook(), [
                'json' => $notification->getData()
            ]);

            return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
        } catch (GuzzleException $e) {
            Log::error('Discord Webhook Fehler: ' . $e->getMessage());
            return false;
        }
    }

    public function send(string $webhook, array $data): bool
    {
        try {
            $response = $this->client->post($webhook, [
                'json' => $data
            ]);

            return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
        } catch (GuzzleException $e) {
            Log::error('Discord Webhook Fehler: ' . $e->getMessage());
            return false;
        }
    }
}
