<?php
declare( strict_types = 1 );

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use seo_db\Models\Author;
use seo_db\Models\Category;
use seo_db\Models\Post;
use seo_db\Models\Tag;

/**
 * Class RouteServiceProvider
 * @package App\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
	/**
	 * This namespace is applied to your controller routes.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * @var string
	 */
	protected static $slugPattern = '[0-9a-zA-Z_-]+';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @return void
	 */
	public function boot ()
	{
		Route::model('category', Category::class);
		Route::pattern('category', self::$slugPattern);

		Route::model('post', Post::class);
		Route::pattern('post', self::$slugPattern);

		Route::model('tag', Tag::class);
		Route::pattern('tag', self::$slugPattern);

		Route::model('author', Author::class);
		Route::pattern('author', self::$slugPattern);

		parent::boot();
	}

	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map () : void
	{
		$this->mapApiRoutes();

		$this->mapWebRoutes();

	}

	/**
	 * Define the "web" routes for the application.
	 *
	 * These routes all receive session state, CSRF protection, etc.
	 *
	 * @return void
	 */
	protected function mapWebRoutes () : void
	{
		Route::middleware('web')
		     ->namespace($this->namespace)
		     ->group(base_path('routes/web.php'));
	}

	/**
	 * Define the "api" routes for the application.
	 *
	 * These routes are typically stateless.
	 *
	 * @return void
	 */
	protected function mapApiRoutes () : void
	{
		Route::prefix('api')
		     ->middleware('api')
		     ->namespace($this->namespace)
		     ->group(base_path('routes/api.php'));
	}
}
