<?php

namespace Beam\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use Beam\Beam;
use Beam\Auth\Activations\ActivationTokenRepository;

class BeamServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Illuminate\Auth\Events\Registered' => [
            'Beam\Listeners\SendAccountActivationNotificationFromRegistration',
        ],
        'Beam\Events\NeedsAccountActivationNotification' => [
            'Beam\Listeners\SendAccountActivationNotification',
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../../database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../../../resources/lang', 'beam');
        $this->publishes([
            __DIR__.'/../../../resources/lang' => resource_path('lang/vendor/beam'),
        ]);
        $this->registerActivationEvents();
        $this->registerCommands();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        $this->registerBeamFacade();
        $this->registerActivationTokenRepository();
    }
    
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../../config/beam.php', 'beam'
        );
    }

    protected function registerCommands()
    {
        $this->commands([
            \Beam\Auth\Console\BeamAuthCommand::class,
        ]);
    }

    protected function registerBeamFacade()
    {
        $this->app->singleton('beam.main', function ($app) {

            return new Beam(
                $app['router']
            );

        });
    }

    protected function registerActivationEvents()
    {
        foreach ($this->listens() as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }
    }

    protected function registerActivationTokenRepository()
    {
        $this->app->singleton('activations.repository', function ($app) {

            $key = $app['config']['app.key'];
            $config = $this->getConfig($this->getDefaultDriver());

            if (Str::startsWith($key, 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }

            $connection = isset($config['connection']) ? $config['connection'] : null;

            return new ActivationTokenRepository(
                $app['db']->connection($connection),
                $config['table'],
                $key,
                $config['expire']
            );
        });
    }

    /**
     * Get the password broker configuration.
     *
     * @param  string  $name
     * @return array
     */
    protected function getConfig($name)
    {
        return $this->app['config']["beam.activations.{$name}"];
    }

    /**
     * Get the default password broker name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['beam.defaults.activations'];
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listen;
    }
}
