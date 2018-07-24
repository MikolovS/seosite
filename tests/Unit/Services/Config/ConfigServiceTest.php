<?php
declare( strict_types = 1 );

namespace Tests\Unit\Services\Config;

use App\Services\Config\ConfigService;
use Faker\Factory;
use ReflectionObject;
use Symfony\Component\HttpFoundation\Request;
use Tests\TestCase;
use Tests\Unit\Services\Config\Factories\DBConfigsFactory;
use Tests\Unit\Services\Config\Factories\LanguagesFactory;

/**
 * Class ConfigServiceTest
 * @package Tests\Unit\Services\Config
 */
class ConfigServiceTest extends TestCase
{
	/**
	 * @group ConfigService
	 * @return ConfigService
	 */
	public function testSetDomain () : ConfigService
	{
		$domain = Factory::create()->domainName;

		$request = $this->createMock(Request::class);

		$request->method('getHttpHost')
		        ->willReturn($domain);

		$configService = $this->app->make(ConfigService::class);

		/** @noinspection PhpParamsInspection */
		$configService->setSiteDomain($request);

		$this->assertEquals(convertDomain($domain), $configService->getSiteDomain());

		return $configService;
	}

	/**
	 * @group   ConfigService
	 * @depends testSetDomain
	 * @param   ConfigService $configService
	 * @return ConfigService
	 */
	public function testSetLocal (ConfigService $configService) : ConfigService
	{
		$languages   = LanguagesFactory::$languages;
		$language    = array_rand($languages, 1);
		$languageAbr = $languages[ $language ];

		$this->invokeMethod($configService, 'setLocal', $languageAbr);

		$this->assertEquals($this->app->getLocale(), $languageAbr);

		return $configService;
	}
}