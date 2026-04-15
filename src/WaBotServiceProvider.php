<?php

declare(strict_types=1);

namespace Lockerace\WaBot;

use Composer\InstalledVersions;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

final class WaBotServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/wabot.php',
            'wabot'
        );

        $this->app->singleton(WaBotService::class);
    }

    public function boot(): void
    {
        AboutCommand::add('Wa Bot Sdk', fn() => ['Version' => InstalledVersions::getPrettyVersion('lockerace/wa-bot-sdk')]);
        $this->publishes([
            __DIR__ . '/../config/wabot.php' => config_path('wabot.php'),
        ], ['wabot', 'config']);
        $state = $this->app->make(WaBotService::class);
        // $this->registerChannels();
    }

    protected function registerChannels()
    {
        $state = app(WaBotService::class);
        Broadcast::channel($state->channelName, function ($user) {
            return true;
        });
    }
}
