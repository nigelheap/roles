<?php

namespace NigelHeap\Roles;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class RolesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/roles.php' => config_path('roles.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../migrations/' => base_path('/database/migrations')
        ], 'migrations');

        $this->registerBladeExtensions();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/roles.php', 'roles');
    }

    /**
     * Register Blade extensions.
     *
     * @return void
     */
    protected function registerBladeExtensions()
    {

        Blade::directive('role', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->isRole{$expression}): ?>";
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('permission', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->can{$expression}): ?>";
        });

        Blade::directive('endpermission', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('level', function ($expression) {
            $level = trim($expression, '()');

            return "<?php if (Auth::check() && Auth::user()->level() >= {$level}): ?>";
        });

        Blade::directive('endlevel', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('allowed', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->allowed{$expression}): ?>";
        });

        Blade::directive('endallowed', function () {
            return "<?php endif; ?>";
        });
    }
}
