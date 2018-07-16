<?php
declare( strict_types = 1 );

namespace App\Services\Config\lib\Classes;

use App\Library\Interfaces\Item;
use App\Library\Interfaces\Mapper;

/**
 * Class DBConfigsMapper
 * @package App\Services\Config\lib\Classes
 */
class DBConfigsMapper implements Mapper
{
	/**
	 * @var DBConfigs
	 */
	protected $dbConfigs;

	/**
	 * DBConfigsMapper constructor.
	 * @param DBConfigs $dbConfigs
	 */
	public function __construct (DBConfigs $dbConfigs)
	{
		$this->dbConfigs = $dbConfigs;
	}

	/**
	 * @param array $configs
	 * @return DBConfigs
	 */
	public function map (array $configs) : Item
	{
		$this->dbConfigs->setDriver($configs[ 'driver' ]);
		$this->dbConfigs->setHost($configs[ 'host' ]);
		$this->dbConfigs->setPort($configs[ 'port' ]);
		$this->dbConfigs->setDatabase($configs[ 'database' ]);
		$this->dbConfigs->setUsername($configs[ 'username' ]);
		$this->dbConfigs->setPassword($configs[ 'password' ]);
		$this->dbConfigs->setCharset($configs[ 'charset' ]);
		$this->dbConfigs->setCollation($configs[ 'collation' ]);
		$this->dbConfigs->setPrefix($configs[ 'prefix' ] ?? '');
		$this->dbConfigs->setStrict($configs[ 'strict' ] ?? false);
		$this->dbConfigs->setEngine($configs[ 'engine' ] ?? '');

		return $this->dbConfigs;
	}
}