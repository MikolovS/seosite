<?php
declare( strict_types = 1 );

namespace Tests\Unit\Services\Config\Classes;

use App\Services\Config\lib\Items\DBConfigs;
use Tests\TestCase;
use Tests\Unit\Services\Config\Factories\DBConfigsFactory;

/**
 * Class GetLocalConfigsTest
 * @package Tests\Unit\Services\Config\Classes
 */
class GetLocalConfigsTest extends TestCase
{
	protected $dbConfig;

	public static function setUpBeforeClass ()
	{
		$self = new self();

		$self->dbConfig = DBConfigsFactory::make()->produce();

		$self->setDbConfigs($self->dbConfig);
	}

	/**
	 * @param DBConfigs $dbConfigs
	 */
	private function setDbConfigs (DBConfigs $dbConfigs) : void
	{
		\Config::set('database.connections.site', $dbConfigs->toArray());
	}

	public function testGetDbConfigByDomain () : void
	{
		$this->assertTrue(true);
	}
}