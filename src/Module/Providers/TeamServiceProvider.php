<?php

namespace RefinedDigital\Team\Module\Providers;

use Illuminate\Support\ServiceProvider;
use RefinedDigital\Team\Commands\Install;
use RefinedDigital\CMS\Modules\Core\Aggregates\PackageAggregate;
use RefinedDigital\CMS\Modules\Core\Aggregates\ModuleAggregate;
use RefinedDigital\CMS\Modules\Core\Aggregates\RouteAggregate;
use RefinedDigital\Team\Module\Http\Repositories\TeamRepository;

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

        try {
            $repo = new TeamRepository();
            $data = $repo->getForSelect(true);
            session()->put('team', $data);
        } catch (\Exception $e) {

        }
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
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><path class="fa-secondary" opacity=".4" d="M112 167c2.6 .5 5.2 .9 7.9 1.3c2.6 .4 5.3 .8 8.1 1.2l0 14.4c0 22.1 17.9 40 40 40c4.1 0 8.3 0 12.4 0c16.5 0 31.1-10.6 36.3-26.2c2.3-7 12.2-7 14.5 0c5.2 15.6 19.9 26.2 36.3 26.2c4.1 0 8.3 0 12.4 0c22.1 0 40-17.9 40-40l0-14.4c5.5-.8 10.9-1.7 16-2.6l0 17c0 61.9-50.1 112-112 112s-112-50.1-112-112l0-17z"/><path class="fa-primary" d="M224 16c-6.7 0-10.8-2.8-15.5-6.1C201.9 5.4 194 0 176 0c-30.5 0-52 43.7-66 89.4C62.7 98.1 32 112.2 32 128c0 17.8 38.6 33.3 96 41.6l0 14.4c0 22.1 17.9 40 40 40l12.4 0c16.5 0 31.1-10.6 36.3-26.2c2.3-7 12.2-7 14.5 0c5.2 15.6 19.9 26.2 36.3 26.2l12.4 0c22.1 0 40-17.9 40-40l0-14.4c57.4-8.3 96-23.8 96-41.6c0-15.8-30.7-29.9-78-38.6C324 43.7 302.5 0 272 0c-18 0-25.9 5.4-32.5 9.9c-4.8 3.3-8.8 6.1-15.5 6.1zm44.1 496l149.2 0c17 0 30.7-13.8 30.7-30.7c0-57-29.6-107.1-74.2-135.8L415 242.4c.6-1.6 1-3.3 1-5c0-7.4-6-13.4-13.4-13.4l-59 0L273.7 490.5l-34-116.6 17.8-29.6c6.4-10.7-1.3-24.2-13.7-24.2L224 320l-19.7 0c-12.4 0-20.1 13.6-13.7 24.2l17.8 29.6-34 116.6L104.4 224l-59 0C38 224 32 230 32 237.4c0 1.7 .3 3.4 1 5L74.2 345.5C29.6 374.2 0 424.3 0 481.3c0 17 13.8 30.7 30.7 30.7l149.2 0 88.1 0z"/></svg>',
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
