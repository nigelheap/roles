<?php

namespace NigelHeap\Roles;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;


class RolesServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/roles.php' => config_path('roles.php')
        ], 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../../migrations/');

        $this->registerBladeExtensions();
    }

    /**
     * Register the application services.
     *
     * @return void
     */

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/roles.php', 'roles');
    }

    public function registerBladeExtensions()
    {

        Blade::directive('role', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->isRole{$expression}): ?>";
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('group', function ($expression) {
            $group = trim($expression, '()');
            return "<?php if (Auth::check() && Auth::user()->group() == $group): ?>";
        });
        Blade::directive('endgroup', function () {
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