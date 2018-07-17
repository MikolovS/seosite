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
	/**
	 * @var ConfigService
	 */
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
	 * @param Request $request
	 * @param Closure $next
	 * @return mixed
	 */
	public function handle (Request $request, Closure $next)
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
		$domainName = 'wnews_blog';

		$this->configService->applySiteConfigs($domainName);
	}
}
