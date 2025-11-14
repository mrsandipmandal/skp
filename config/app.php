<?php

use Illuminate\Support\Facades\Facade;

return [
    /* App Configuration */
    'name' => env('APP_NAME', 'Laravel'),
    'logo' => env('APP_LOGO', '/public/static/logo.jpeg'),
    'logo_dark' => env('APP_LOGO_DARK', '/public/static/logo-bg.png'),
    'header' => env('APP_HEADER', '/public/static/header.jpg'),
    'email' => env('APP_EMAIL', 'info@onnetsolution.com'),
    'mobile' => env('APP_MOBILE', '0123456789'),
    /* /App Configuration */

    /* SMS Configuration */
    'sms_sender_id' => env('SMS_SENDERID', 'your-sender-id'),
    'sms_username' => env('SMS_USERNAME', 'your-api-key'),
    'sms_apikey' => env('SMS_APIKEY', 'your-api-key'),
    /* /SMS Configuration */

    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'asset_url' => env('ASSET_URL'),
    'timezone' => 'UTC',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],
    'providers' => [
        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ],
    'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
        // 'DNS1D' => Milon\Barcode\Facades\DNS1DFacade::class,
        // 'DNS2D' => Milon\Barcode\Facades\DNS2DFacade::class,
        'Helper' => App\Helpers\Helper::class,
        'GoogleImageUpload' => App\Helpers\GoogleImageUpload::class,
    ])->toArray(),

];
