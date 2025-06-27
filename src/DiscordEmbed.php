<?php

declare(strict_types=1);

namespace Koeker\LaravelDiscordNotification;

class DiscordEmbed
{
    protected DiscordNotification $notification;
    protected array $embed = [];

    public function __construct(
        DiscordNotification $notification
    ){
        $this->notification = $notification;
    }

    public function setTitle(string $title): self
    {
        $this->embed['title'] = $title;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->embed['description'] = $description;
        return $this;
    }

    public function setColor(int $color): self
    {
        $this->embed['color'] = $color;
        return $this;
    }

    public function setThumbnail(string $url): self
    {
        $this->embed['thumbnail'] = ['url' => $url];
        return $this;
    }

    public function setImage(string $url): self
    {
        $this->embed['image'] = ['url' => $url];
        return $this;
    }

    public function setAuthor(string $name, ?string $url = null, ?string $iconUrl = null): self
    {
        $author = ['name' => $name];
        if ($url) $author['url'] = $url;
        if ($iconUrl) $author['icon_url'] = $iconUrl;

        $this->embed['author'] = $author;
        return $this;
    }

    public function setFooter(string $text, ?string $iconUrl = null): self
    {
        $footer = ['text' => $text];
        if ($iconUrl) $footer['icon_url'] = $iconUrl;

        $this->embed['footer'] = $footer;
        return $this;
    }

    public function setTimestamp(?string $timestamp = null): self
    {
        $this->embed['timestamp'] = $timestamp ?? now()->toISOString();
        return $this;
    }

    public function addField(string $name, string $value, bool $inline = false): self
    {
        if (!isset($this->embed['fields'])) {
            $this->embed['fields'] = [];
        }

        $this->embed['fields'][] = [
            'name' => $name,
            'value' => $value,
            'inline' => $inline
        ];

        return $this;
    }

    public function build(): DiscordNotification
    {
        $this->notification->addEmbed($this->embed);
        return $this->notification;
    }
}
