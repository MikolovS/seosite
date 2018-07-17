<?php
declare( strict_types = 1 );

namespace Tests\Unit\Services\Config\Classes;

use App\Services\Config\lib\Classes\GetLocalConfigs;
use App\Services\Config\lib\Items\DBConfigs;
use Illuminate\Config\Repository;
use Tests\TestCase;
use Tests\Unit\Services\Config\Factories\DBConfigsFactory;

/**
 * Class GetLocalConfigsTest
 * @package Tests\Unit\Services\Config\Classes
 */
class GetLocalConfigsTest extends TestCase
{
	/**
	 * @var DBConfigs
	 */
	protected static $dbConfig;

	/**
	 * @var GetLocalConfigs
	 */
	protected static $configGetter;

	/**
	 *
	 */
	public static function setUpBeforeClass ()
	{
		static::$dbConfig = DBConfigsFactory::make()
		                                    ->produce();

		$dbConfigs = static::$dbConfig;

		$domainName = $dbConfigs->getConnectionName();

		$configs = (new self())->createMock(Repository::class);

		$configs->method('get')
		        ->with('database.connections')
		        ->willReturn([
			        $domainName => $dbConfigs->toArray(),
		        ]);

		/** @noinspection PhpParamsInspection */
		static::$configGetter = new GetLocalConfigs($configs);
	}

	/**
	 *
	 */
	public function testGetDbConfigByDomain () : void
	{
		$dbConfigs = static::$dbConfig;

		$domainName = $dbConfigs->getConnectionName();

		$retriedConfigs = static::$configGetter->getDbConfigByDomain($domainName);

		$retriedConfigs->setConnectionName($domainName);

		$this->assertEquals($retriedConfigs, $dbConfigs);
	}
}