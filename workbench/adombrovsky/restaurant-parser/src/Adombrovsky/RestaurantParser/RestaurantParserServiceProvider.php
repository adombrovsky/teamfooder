<?php namespace Adombrovsky\RestaurantParser;

use Illuminate\Support\ServiceProvider;

/**
 * Class RestaurantParserServiceProvider
 * @package Adombrovsky\RestaurantParser
 */
class RestaurantParserServiceProvider extends ServiceProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('adombrovsky/restaurant-parser');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app['restaurantParser'] = $this->app->share(function($app)
        {
            return new RestaurantParser();
        });

        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('RestaurantParser', 'Adombrovsky\RestaurantParser\Facades\RestaurantParser');
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
