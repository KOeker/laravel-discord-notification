# 🚀 Laravel Discord Webhook

[![Latest Stable Version](https://img.shields.io/packagist/v/koeker/laravel-discord-notification.svg)](https://packagist.org/packages/koeker/laravel-discord-notification)
[![Total Downloads](https://img.shields.io/packagist/dt/koeker/laravel-discord-notification.svg)](https://packagist.org/packages/koeker/laravel-discord-notification)
[![License](https://img.shields.io/packagist/l/koeker/laravel-discord-notification.svg)](https://packagist.org/packages/koeker/laravel-discord-notification)

A lightweight and simple Laravel package for sending Discord webhook embeds. Perfect for monitoring, alerts, and notifications.

## ✨ Features

- **Full Embed Support** – Title, description, fields, footer, colors, and more
- **Custom Bot Name & Avatar** – Set directly when initializing
- **Laravel Integration** – Service Provider, Facade, Auto-Discovery

## 📦 Installation

```bash
composer require koeker/laravel-discord-notification
```

The package is auto-discovered by Laravel. No further setup required.

## 🚀 Quick Start

```php
use Koeker\LaravelDiscordNotification\Facades\LaravelDiscordNotification;

$webhook = 'https://discord.com/api/webhooks/YOUR-WEBHOOK-URL';

$notification = LaravelDiscordNotification::setWebhookAgent(
    $webhook,
    'Laravel Bot',
    'https://example.png'
);

// Create embed
$notification->createEmbed()
    ->setTitle('🎉 Deployment Successful')
    ->setDescription('Version 2.1.0 has been successfully deployed!')
    ->setColor(0x00FF00)
    ->setFooter('CI/CD Pipeline')
    ->setTimestamp()
    ->addField('Server', 'Production', true)
    ->addField('Duration', '2min 34s', true)
    ->build();

$success = LaravelDiscordNotification::sendNotification($notification);
```

## 📚 Full Examples

### System Alert with Error Information

```php
$notification = LaravelDiscordNotification::setWebhookAgent(
    $webhook,
    'System Monitor',
    'https://example.com/alert-bot.png'
);

$notification->createEmbed()
    ->setTitle('🚨 System Alert')
    ->setDescription('Critical Error!')
    ->setColor(0xFF0000)  // Rot
    ->setFooter('Laravel Monitoring System')
    ->setTimestamp()
    ->addField('Code', '500 Internal Server Error', true)
    ->addField('Routes', '/api/users', true)
    ->addField('Server', 'web-01.production', true)
    ->build();

LaravelDiscordNotification::sendNotification($notification);
```

### Multiple Embeds in one Notification

```php
$notification = LaravelDiscordNotification::setWebhookAgent($webhook, 'Status Bot');

// Server Status
$notification->createEmbed()
    ->setTitle('✅ Server Online')
    ->setDescription('All Services running normal')
    ->setColor(0x00FF00)
    ->build();

// Performance Metrics
$notification->createEmbed()
    ->setTitle('📊 Performance')
    ->setDescription('System-Metrics')
    ->setColor(0x0099FF)
    ->addField('CPU', '25%', true)
    ->addField('RAM', '60%', true)
    ->addField('Disk', '45%', true)
    ->addField('Uptime', '99.9%', true)
    ->addField('Response Time', '50ms', true)
    ->addField('Active Users', '1,234', true)
    ->build();

LaravelDiscordNotification::sendNotification($notification);
```

### Inside a Laravel Controller

```php
class MonitoringController extends Controller
{
    public function sendHealthCheck()
    {
        $webhook = env('DISCORD_WEBHOOK_URL');
        
        $notification = LaravelDiscordNotification::setWebhookAgent(
            $webhook,
            config('app.name') . ' Monitor',
            'https://example.png'
        );
            
        $notification->createEmbed()
            ->setTitle('💚 Health Check')
            ->setDescription('All Systems good')
            ->setColor(0x00FF00)
            ->setFooter('Automated Health Check')
            ->setTimestamp()
            ->addField('Database', '✅ Connected', true)
            ->addField('Cache', '✅ Working', true)
            ->addField('Queue', '✅ Processing', true)
            ->build();
            
        if (LaravelDiscordNotification::sendNotification($notification)) {
            return response()->json(['status' => 'Health check sent to Discord']);
        }
        
        return response()->json(['status' => 'Failed to send notification'], 500);
    }
}
```

### Inside a Job Laravel Queue

```php
class SendDiscordAlert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $title;
    protected $message;
    protected $color;

    public function __construct($title, $message, $color = 0x0099FF)
    {
        $this->title = $title;
        $this->message = $message;
        $this->color = $color;
    }

    public function handle()
    {
        $webhook = env('DISCORD_WEBHOOK_URL');
        
        $notification = LaravelDiscordNotification::setWebhookAgent(
            $webhook,
            'Queue Worker',
            'https://example.com/worker-avatar.png'
        );

        $notification->createEmbed()
            ->setTitle($this->title)
            ->setDescription($this->message)
            ->setColor($this->color)
            ->setFooter('Laravel Queue System')
            ->setTimestamp()
            ->build();

        LaravelDiscordNotification::sendNotification($notification);
    }
}

// Job dispatch
SendDiscordAlert::dispatch('🎯 Task Completed', 'Import successfull', 0x00FF00);
```

## 🎨 Embed-Methods

| Methods                              | Description               | Example |
|--------------------------------------|---------------------------|----------|
| `setTitle(string)`                   | Title of the embed        | `->setTitle('🚀 Deployment')` |
| `setDescription(string)`             | Main text                 | `->setDescription('Successfully deployed!')` |
| `setColor(int)`                      | Color (hex)               | `->setColor(0x00FF00)` |
| `setFooter(string, ?string)`         | Footer with optional Icon | `->setFooter('System', 'icon.png')` |
| `setTimestamp(?string)`              | Timestamp                 | `->setTimestamp()` |
| `addField(string, string, bool)`     | Add a field               | `->addField('Status', 'OK', true)` |
| `setAuthor(string, ?string, ?string)` | Author with link and icon | `->setAuthor('Laravel', 'laravel.com')` |
| `setThumbnail(string)`               | Small picture top right   | `->setThumbnail('thumb.png')` |
| `setImage(string)`                   | Big picture               | `->setImage('screenshot.png')` |

## 🎯 Colors

```php
// Success (Green)
->setColor(0x00FF00)

// Error (Red)  
->setColor(0xFF0000)

// Warning (Orange)
->setColor(0xFFAA00)

// Info (Blue)
->setColor(0x0099FF)

// Discord Blurple
->setColor(0x5865F2)
```

## 🛠️ Requirements

- PHP >= 8.0
- Laravel >= 8.0
- GuzzleHttp >= 7.0

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

## 🙋‍♂️ Support

Issues?
- 🐛 [Issues auf GitHub](https://github.com/KOeker/laravel-discord-notification/issues)

---
