<?php
declare( strict_types = 1 );

namespace App\Services\Config;

use App\Services\Config\lib\Classes\GetConfigs;
use Illuminate\Http\Request;

/**
 * Class ConfigService
 * @package App\Services
 */
class ConfigService
{
	/**
	 * @var string
	 */
	private $siteDomain;

	/**
	 * @var GetConfigs
	 */
	private $configGetter;

	/**
	 * SiteConfigService constructor.
	 * @param GetConfigs $getConfigs
	 */
	public function __construct (GetConfigs $getConfigs)
	{
		$this->configGetter = $getConfigs;
	}

	/**
	 * @return string
	 */
	public function getSiteDomain () : string
	{
		return $this->siteDomain;
	}

	/**
	 * @param Request $request
	 */
	public function setSiteDomain (Request $request) : void
	{
		$this->siteDomain = $request->getHttpHost();
	}

	/**
	 * @param array $siteConfigs
	 */
	private function setDbConnection (array $siteConfigs) : void
	{
		\Config::set('database.connections.site', $siteConfigs);
	}

	/**
	 * @param string $language
	 */
	private function setLocal (string $language) : void
	{
		\App::setLocale($language);
	}

	/**
	 * @param string $domainName
	 */
	public function applySiteConfigs (string $domainName) : void
	{
		$dbConfigs = $this->configGetter->getDbConfigByDomain($domainName);
		$this->setDbConnection($dbConfigs);

		$language = $this->configGetter->getSiteLanguage($domainName);
		$this->setLocal($language);
	}
}