<?php
declare( strict_types = 1 );


namespace Tests\Unit\Services\Config\Factories;

use App\Services\Config\lib\Items\DBConfigs;
use App\Services\Config\lib\Mappers\DBConfigsMapper;
use Tests\Library\Factories\AbstractFactory;

/**
 * Class DBConfigsArrayFactory
 * @package Tests\Unit\Services\Config\Factories
 */
class DBConfigsFactory extends AbstractFactory
{
	/**
	 * @var DBConfigsMapper
	 */
	protected $configsMapper;

	/**
	 * DBConfigsFactory constructor.
	 */
	public function __construct ()
	{
		$this->configsMapper = new DBConfigsMapper();

		parent::__construct();
	}

	/**
	 * @return DBConfigs
	 */
	public function produce () : DBConfigs
	{
		$configsArray = [
			'connectionName' => convertDomain($this->faker->domainName),
			'driver'         => $this->faker->domainWord,
			'host'           => (string) $this->faker->ipv4,
			'port'           => (string) $this->faker->randomDigit,
			'database'       => $this->faker->name,
			'username'       => $this->faker->name,
			'password'       => $this->faker->password(),
			'charset'        => $this->faker->randomLetter,
			'collation'      => $this->faker->randomLetter,
			'prefix'         => $this->faker->randomLetter,
			'strict'         => $this->faker->boolean,
			'engine'         => $this->faker->name,
		];

		return $this->configsMapper->map($configsArray);
	}
}