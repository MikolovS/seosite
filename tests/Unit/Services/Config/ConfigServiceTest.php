<?php
declare( strict_types = 1 );

namespace Tests\Unit\Services\Config;

use App;
use App\Services\Config\ConfigService;
use Faker\Factory;
use Config;
use Tests\TestCase;
use Tests\Unit\Services\Config\Factories\LanguagesFactory;

/**
 * Class ConfigServiceTest
 * @package Tests\Unit\Services\Config
 */
class ConfigServiceTest extends TestCase
{
	/**
	 * @var ConfigService
	 */
	private static $configService;

	/**
	 *
	 */
	public function setUp () : void
	{
		parent::setUp();

		self::$configService = App::make(ConfigService::class);
	}

	/**
	 * @group ConfigService
	 */
	public function testSetDomain () : void
	{
		$domain = Factory::create()->domainName;

		/** @noinspection PhpParamsInspection */
		self::$configService->setSiteDomain($domain);

		$this->assertEquals(convertDomain($domain), self::$configService->getSiteDomain());
	}

	/**
	 * @group   ConfigService
	 */
	public function testSetLocal () : void
	{
		$languages   = LanguagesFactory::$languages;
		$language    = array_rand($languages, 1);
		$languageAbr = $languages[ $language ];

		$this->invokeMethod(self::$configService, 'setLocal', $languageAbr);

		$this->assertEquals($this->app->getLocale(), $languageAbr);
	}

	/**
	 * @group   ConfigService
	 */
	public function testApplySiteConfigs () : void
	{
		$domain = collect(Config::get('database.connections'))
			->filter(function ($connection, $name) {
				return preg_match('/wnews_./', $name);
			})
			->keys()
			->first();

		$configService = $this->app->make(ConfigService::class);

		$configService->applySiteConfigs($domain);

		$domainConfigs = Config::get('database.connections.' . $domain);

		$dbConfigs = \DB::connection()
		                ->getConfig();
		unset($dbConfigs[ 'name' ]);

		$this->assertEquals($dbConfigs, $domainConfigs);

		$siteLang = collect(Config::get('site.languages'))
			->filter(function ($config) use ($domain) {
				return \in_array($domain, $config, true);
			})
			->keys()
			->first();

		$this->assertEquals($siteLang, $this->app->getLocale());
	}
}