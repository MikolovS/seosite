<?php
declare( strict_types = 1 );

namespace App\Http\Middleware;

use App\Services\Config\ConfigService;
use Closure;
use Illuminate\Http\Request;

/**
 * Class SetSiteConfigs
 * @package App\Http\Middleware
 */
class SetSiteConfigs
{
	private $configService;

	/**
	 * SetSiteConfigs constructor.
	 * @param ConfigService $configService
	 */
	public function __construct (ConfigService $configService)
	{
		$this->configService = $configService;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 * @return Request
	 */
	public function handle (Request $request, Closure $next) : Request
	{
		$this->setConfigs($request);

		return $next($request);
	}

	/**
	 * @param Request $request
	 */
	private function setConfigs(Request $request) : void
	{
//		todo Delete
//		$domainName = $request->getHttpHost();
		$domainName = 'wnews.blog';

		$this->configService->applySiteConfigs($domainName);
	}
}
