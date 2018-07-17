<?php
declare( strict_types = 1 );

namespace Tests\Unit\Services\Config\Classes;

use App\Services\Config\lib\Classes\GetLocalConfigs;
use Faker\Factory;
use Illuminate\Config\Repository;
use Tests\TestCase;
use Tests\Unit\Services\Config\Factories\DBConfigsFactory;
use Tests\Unit\Services\Config\Factories\LanguagesFactory;

/**
 * Class GetLocalConfigsTest
 * @package Tests\Unit\Services\Config\Classes
 */
class GetLocalConfigsTest extends TestCase
{
	/**
	 *
	 */
	private function getDomain () : string
	{
		$domain = Factory::create()->domainName;

		return convertDomain($domain);
	}

	/**
	 *
	 */
	public function testGetDbConfigByDomain () : void
	{
		$domain = $this->getDomain();

		$dbConfigs = DBConfigsFactory::make()
		                             ->produce();

		$configs = $this->createMock(Repository::class);

		$configs->method('get')
		        ->with('database.connections')
		        ->willReturn([
			        $domain => $dbConfigs->toArray(),
		        ]);

		/** @noinspection PhpParamsInspection */
		$retriedConfigs = ( new GetLocalConfigs($configs) )->getDbConfigByDomain($domain);

		$this->assertEquals($retriedConfigs, $dbConfigs);
	}

	/**
	 *
	 */
	public function testGetSiteLanguage () : void
	{
		$domain = $this->getDomain();

		$languages = LanguagesFactory::make($domain)
		                             ->produce();

		$domainLanguage = collect($languages)->filter(function ($domains) use ($domain) {
			foreach ($domains as $domainItem) {
				if ($domainItem === $domain)
					return true;
			}
			return false;
		})->keys()->first();

		$configs = $this->createMock(Repository::class);

		$configs->method('get')
		        ->with('language.sites_languages')
		        ->willReturn($languages);

		/** @noinspection PhpParamsInspection */
		$retrievedLanguage = ( new GetLocalConfigs($configs) )->getSiteLanguage($domain);

		$this->assertEquals($retrievedLanguage, $domainLanguage);
	}
}