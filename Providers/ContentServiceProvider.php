<?php
namespace App\Modules\Content\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class ContentServiceProvider extends ServiceProvider
{
	/**
	 * Register the Content module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Content\Providers\RouteServiceProvider');

		//Bind ContentRepository Facade to the IoC Container
		App::bind('ContentRepository', function()
		{
			return new App\Modules\Content\Repositories\ContentRepository;
		});

		$this->registerNamespaces();
	}

	/**
	 * Register the Content module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('content', __DIR__.'/../Resources/Lang/');

		View::addNamespace('content', __DIR__.'/../Resources/Views/');
	}
}
