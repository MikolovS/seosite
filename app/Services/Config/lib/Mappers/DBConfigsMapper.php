<?php
declare( strict_types = 1 );

namespace App\Services\Config\lib\Mappers;

use App\Library\Interfaces\Item;
use App\Library\Interfaces\Mapper;
use App\Services\Config\lib\Items\DBConfigs;

/**
 * Class DBConfigsMapper
 * @package App\Services\Config\lib\Classes
 */
class DBConfigsMapper implements Mapper
{
	/**
	 * @param array $configs
	 * @return DBConfigs
	 */
	public function map (array $configs) : Item
	{
		$dbConfigs = new DBConfigs();

		$dbConfigs->setConnectionName($configs[ 'connectionName' ] ?? '');
		$dbConfigs->setDriver($configs[ 'driver' ]);
		$dbConfigs->setHost($configs[ 'host' ]);
		$dbConfigs->setPort($configs[ 'port' ]);
		$dbConfigs->setDatabase($configs[ 'database' ]);
		$dbConfigs->setUsername($configs[ 'username' ]);
		$dbConfigs->setPassword($configs[ 'password' ]);
		$dbConfigs->setCharset($configs[ 'charset' ]);
		$dbConfigs->setCollation($configs[ 'collation' ]);
		$dbConfigs->setPrefix($configs[ 'prefix' ] ?? '');
		$dbConfigs->setStrict($configs[ 'strict' ] ?? false);
		$dbConfigs->setEngine($configs[ 'engine' ] ?? '');

		return $dbConfigs;
	}
}