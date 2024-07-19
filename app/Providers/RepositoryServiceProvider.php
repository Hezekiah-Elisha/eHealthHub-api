<?php

namespace App\Providers;

use App\Interfaces\AppointmentRepositoryInterface;
use App\Repositories\AppointmentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            AppointmentRepositoryInterface::class,
            AppointmentRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
