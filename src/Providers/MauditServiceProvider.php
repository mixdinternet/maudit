<?php

namespace Mixdinternet\Maudit\Providers;

use Illuminate\Support\ServiceProvider;
use Pingpong\Menus\MenuFacade as Menu;

class MauditServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setMenu();

        $this->setRoutes();

        $this->loadViews();

        $this->publish();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    protected function setMenu()
    {
        Menu::modify('adminlte-sidebar', function ($menu) {
            $menu->route('admin.maudit.index', 'Logs', [], 210
                , ['icon' => 'fa fa-tasks', 'active' => function () {
                    return checkActive(route('admin.maudit.index'));
                }])->hideWhen(function () {
                return checkRule('admin.maudit.index');
            });
        });

        Menu::modify('adminlte-permissions', function ($menu) {
            $menu->url('admin.maudit.index', 'Logs', 210, ['except' => ['create', 'edit', 'destroy', 'trash']]);
        });

    }

    protected function setRoutes()
    {
        if (!$this->app->routesAreCached()) {
            $this->app->router->group(['namespace' => 'Mixdinternet\Maudit\Http\Controllers'],
                function () {
                    require __DIR__ . '/../Http/routes.php';
                });
        }
    }

    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mixdinternet/maudit');
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/mixdinternet/maudit'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../config' => base_path('config'),
        ], 'config');
    }
}
