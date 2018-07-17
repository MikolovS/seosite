<?php
declare( strict_types = 1 );

namespace Tests\Library\Factories;

use Faker\Factory as FakerFactory;

/**
 * Class AbstractFactory
 * @package Tests\Library\Factories
 */
abstract class AbstractFactory
{
	/**
	 * @var FakerFactory
	 */
	protected $faker;

	/**
	 * AbstractFactory constructor.
	 */
	public function __construct ()
	{
		$this->faker = FakerFactory::create();
	}

	/**
	 * @return mixed
	 */
	abstract public function produce();

	/**
	 * @return AbstractFactory
	 */
	public static function make() : self
	{
		return new static();
	}
}