<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Models\Repositories\Interface\UserInterface::class, \App\Models\Repositories\UserRepository::class);
        $this->app->bind(\App\Models\Repositories\Interface\ProfessionalInterface::class, \App\Models\Repositories\ProfessionalRepository::class);
        $this->app->bind(\App\Models\Repositories\Interface\AppointmentInterface::class, \App\Models\Repositories\AppointmentRepository::class);
    }
    /**
     *
     * @return void
     */
    public function boot()
    {
    }
}
