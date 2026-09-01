<?php

declare(strict_types=1);

namespace Modules\Sample\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Sample\Listeners\LogFileActivity;
use Modules\Sample\Listeners\LogSettingChange;

class SampleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // ============================================================
        // CONTOH HOOK #1 — dengarkan event Spine: FileUploading/FileUploaded
        // (dipicu dari FileService::storeUpload / deleteUpload)
        // ============================================================
        Event::listen(\Spine\Events\FileUploading::class, LogFileActivity::class . '@uploading');
        Event::listen(\Spine\Events\FileUploaded::class, LogFileActivity::class . '@uploaded');
        Event::listen(\Spine\Events\FileDeleting::class, LogFileActivity::class . '@deleting');
        Event::listen(\Spine\Events\FileDeleted::class, LogFileActivity::class . '@deleted');

        // ============================================================
        // CONTOH HOOK #2 — dengarkan event Spine: SettingUpdated
        // (dipicu dari SettingService::set)
        // ============================================================
        Event::listen(\Spine\Events\SettingUpdated::class, LogSettingChange::class);
    }
}
