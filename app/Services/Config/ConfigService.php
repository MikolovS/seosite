<?php
declare( strict_types = 1 );

namespace App\Services\Config;

use App\Services\Config\lib\Classes\GetLocalConfigs;
use App\Services\Config\lib\Interfaces\ConfigGetter;
use App\Services\Config\lib\Items\DBConfigs;
use Illuminate\Config\Repository;

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
	 * @param string $domain
	 */
	public function setSiteDomain (string $domain) : void
	{
		$this->siteDomain = convertDomain($domain);
	}

	/**
	 * @param DBConfigs $siteConfigs
	 */
	private function setDbConnection (DBConfigs $siteConfigs) : void
	{
		$this->config->set('database.connections.seo_site', $siteConfigs->toArray());
	}

	/**
	 * Set app name (siteName)
	 */
	private function setAppName () : void
	{
		$nameParts = explode('_', $this->getSiteDomain());

		foreach ($nameParts as $key => $namePart)
			$nameParts[$key] = ucfirst($namePart);

		$appName = implode(' ', $nameParts);

		$this->config->set('app.name', $appName);
	}

	/**
	 * @param string $language
	 */
	private function setLocal (string $language) : void
	{
		\App::setLocale($language);
	}

	/**
	 * @param string $domain
	 */
	public function applySiteConfigs (string $domain) : void
	{
		$this->setSiteDomain($domain);

		$dbConfigs = $this->configGetter->getDbConfigByDomain($this->getSiteDomain());

		$this->setDbConnection($dbConfigs);

		$language = $this->configGetter->getSiteLanguage($this->getSiteDomain());
		$this->setLocal($language);

		$this->setAppName();
	}
}