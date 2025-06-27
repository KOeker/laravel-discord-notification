<?php

declare(strict_types=1);

namespace Koeker\LaravelDiscordNotification;

class DiscordNotification
{
    protected string $webhook;
    protected array $data = [];

    public function __construct(
        string $webhook
    ){
        $this->webhook = $webhook;
        $this->data['embeds'] = [];
    }

    public function setUsername(string $username): self
    {
        $this->data['username'] = $username;
        return $this;
    }

    public function setAvatarUrl(string $avatarUrl): self
    {
        $this->data['avatar_url'] = $avatarUrl;
        return $this;
    }

    public function addEmbed(array $embed): self
    {
        $this->data['embeds'][] = $embed;
        return $this;
    }

    public function createEmbed(): DiscordEmbed
    {
        return new DiscordEmbed($this);
    }

    public function getWebhook(): string
    {
        return $this->webhook;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
