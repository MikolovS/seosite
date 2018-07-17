<?php
declare( strict_types = 1 );

namespace App\Services\Config\lib\Items;

use App\Library\Interfaces\Item;

/**
 * Class DBConfigs
 * @package App\Services\Config\lib\Classes
 */
class DBConfigs implements Item
{
	/**
	 * @var string
	 */
	protected $connectionName;

	/**
	 * @var string
	 */
	protected $driver;
	/**
	 * @var string
	 */
	protected $host;
	/**
	 * @var string
	 */
	protected $port;
	/**
	 * @var string
	 */
	protected $database;
	/**
	 * @var string
	 */
	protected $username;
	/**
	 * @var string
	 */
	protected $password;
	/**
	 * @var string
	 */
	protected $charset;
	/**
	 * @var string
	 */
	protected $collation;
	/**
	 * @var string
	 */
	protected $prefix;
	/**
	 * @var bool
	 */
	protected $strict;
	/**
	 * @var string
	 */
	protected $engine;

	/**
	 * @return string
	 */
	public function getConnectionName () : string
	{
		return $this->connectionName;
	}

	/**
	 * @param string $connectionName
	 */
	public function setConnectionName (string $connectionName) : void
	{
		$this->connectionName = $connectionName;
	}

	/**
	 * @return string
	 */
	public function getDriver () : string
	{
		return $this->driver;
	}

	/**
	 * @param string $driver
	 */
	public function setDriver (string $driver) : void
	{
		$this->driver = $driver;
	}

	/**
	 * @return string
	 */
	public function getHost () : string
	{
		return $this->host;
	}

	/**
	 * @param string $host
	 */
	public function setHost (string $host) : void
	{
		$this->host = $host;
	}

	/**
	 * @return string
	 */
	public function getPort () : string
	{
		return $this->port;
	}

	/**
	 * @param string $port
	 */
	public function setPort (string $port) : void
	{
		$this->port = $port;
	}

	/**
	 * @return string
	 */
	public function getDatabase () : string
	{
		return $this->database;
	}

	/**
	 * @param string $database
	 */
	public function setDatabase (string $database) : void
	{
		$this->database = $database;
	}

	/**
	 * @return string
	 */
	public function getUsername () : string
	{
		return $this->username;
	}

	/**
	 * @param string $username
	 */
	public function setUsername (string $username) : void
	{
		$this->username = $username;
	}

	/**
	 * @return string
	 */
	public function getPassword () : string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword (string $password) : void
	{
		$this->password = $password;
	}

	/**
	 * @return string
	 */
	public function getCharset () : string
	{
		return $this->charset;
	}

	/**
	 * @param string $charset
	 */
	public function setCharset (string $charset) : void
	{
		$this->charset = $charset;
	}

	/**
	 * @return string
	 */
	public function getCollation () : string
	{
		return $this->collation;
	}

	/**
	 * @param string $collation
	 */
	public function setCollation (string $collation) : void
	{
		$this->collation = $collation;
	}

	/**
	 * @return string
	 */
	public function getPrefix () : string
	{
		return $this->prefix;
	}

	/**
	 * @param string $prefix
	 */
	public function setPrefix (string $prefix) : void
	{
		$this->prefix = $prefix;
	}

	/**
	 * @return bool
	 */
	public function isStrict () : bool
	{
		return $this->strict;
	}

	/**
	 * @param bool $strict
	 */
	public function setStrict (bool $strict) : void
	{
		$this->strict = $strict;
	}

	/**
	 * @return string
	 */
	public function getEngine () : string
	{
		return $this->engine;
	}

	/**
	 * @param string $engine
	 */
	public function setEngine (string $engine) : void
	{
		$this->engine = $engine;
	}

	/**
	 * @return array
	 */
	public function toArray () : array
	{
		return [
			'driver'    => $this->getDriver(),
			'host'      => $this->getHost(),
			'port'      => $this->getPort(),
			'database'  => $this->getDatabase(),
			'username'  => $this->getUsername(),
			'password'  => $this->getPassword(),
			'charset'   => $this->getCharset(),
			'collation' => $this->getCollation(),
			'prefix'    => $this->getPrefix(),
			'strict'    => $this->isStrict(),
			'engine'    => $this->getEngine(),
		];
	}
}