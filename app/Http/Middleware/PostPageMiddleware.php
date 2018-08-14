<?php
declare( strict_types = 1 );

namespace App\Http\Middleware;

use App\Http\Requests\PostPageRequest;
use Closure;

/**
 * Class PostPageMiddleware
 * @package App\Http\Middleware
 */
class PostPageMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param PostPageRequest $request
	 * @param  \Closure       $next
	 * @return mixed
	 */
	public function handle ($request, Closure $next)
	{
		if ($request->post->category_id !== $request->category->id)
			abort(404);

		return $next($request);
	}
}
