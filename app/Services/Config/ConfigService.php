<?php
declare( strict_types = 1 );

namespace App\Services\Config;

use App\Services\Config\lib\Classes\GetLocalConfigs;
use App\Services\Config\lib\Interfaces\ConfigGetter;
use App\Services\Config\lib\Items\DBConfigs;
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
	protected $siteDomain;

	/**
	 * @var ConfigGetter
	 */
	protected $configGetter;

	/**
	 * SiteConfigService constructor.
	 * @param GetLocalConfigs $getConfigs
	 */
	public function __construct (GetLocalConfigs $getConfigs)
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
	 * @param DBConfigs $siteConfigs
	 */
	private function setDbConnection (DBConfigs $siteConfigs) : void
	{
		\Config::set('database.connections.site', $siteConfigs->toArray());
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