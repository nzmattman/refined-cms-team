<?php

namespace RefinedDigital\Team\Module\Providers;

use Illuminate\Support\ServiceProvider;
use RefinedDigital\Team\Commands\Install;
use RefinedDigital\CMS\Modules\Core\Aggregates\PackageAggregate;
use RefinedDigital\CMS\Modules\Core\Aggregates\ModuleAggregate;
use RefinedDigital\CMS\Modules\Core\Aggregates\RouteAggregate;

class TeamServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->addNamespace('team', [
            base_path().'/resources/views',
            __DIR__.'/../Resources/views',
        ]);

        try {
            if ($this->app->runningInConsole()) {
                if (\DB::connection()->getDatabaseName() && !\Schema::hasTable('teams')) {
                    $this->commands([
                        Install::class,
                    ]);
                }
            }
        } catch (\Exception $e) {}

        $this->publishes([
            __DIR__.'/../../../config/team.php' => config_path('team.php'),
        ], 'team');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        app(RouteAggregate::class)
            ->addRouteFile('team', __DIR__.'/../Http/routes.php');


        $this->mergeConfigFrom(__DIR__.'/../../../config/team.php', 'team');

        $menuConfig = [
            'order' => 205,
            'name' => 'Team',
            'icon' => 'fas fa-users',
            'route' => 'team',
            'activeFor' => ['team']
        ];

        app(ModuleAggregate::class)
            ->addMenuItem($menuConfig);

        app(PackageAggregate::class)
            ->addPackage('Team', [
                'repository' => \RefinedDigital\Team\Module\Http\Repositories\TeamRepository::class,
                'model' => '\\RefinedDigital\\Team\\Module\\Models\\Team',
            ]);
    }
}
