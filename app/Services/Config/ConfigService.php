<?php
declare( strict_types = 1 );

namespace App\Services\Config;

use App\Services\Config\lib\Classes\GetLocalConfigs;
use App\Services\Config\lib\Interfaces\ConfigGetter;
use App\Services\Config\lib\Items\DBConfigs;
use Illuminate\Config\Repository;
use Symfony\Component\HttpFoundation\Request;

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
	 * @var Repository
	 */
	protected $config;

	/**
	 * SiteConfigService constructor.
	 * @param GetLocalConfigs $getConfigs
	 * @param Repository      $config
	 */
	public function __construct (GetLocalConfigs $getConfigs, Repository $config)
	{
		$this->configGetter = $getConfigs;
		$this->config       = $config;
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
		$this->siteDomain = convertDomain($request->getHttpHost());
	}

	/**
	 * @param DBConfigs $siteConfigs
	 */
	private function setDbConnection (DBConfigs $siteConfigs) : void
	{
		$this->config->set('database.connections.site', $siteConfigs->toArray());
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