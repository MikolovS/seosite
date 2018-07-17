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
	 * @var mixed
	 */
	protected $requiredAttribute;

	/**
	 * AbstractFactory constructor.
	 * @param mixed|null $requiredAttribute
	 */
	public function __construct ($requiredAttribute = null)
	{
		$this->faker             = FakerFactory::create();
		$this->requiredAttribute = $requiredAttribute;
	}

	/**
	 * @return mixed
	 */
	abstract public function produce ();

	/**
	 * @return AbstractFactory
	 */
	public static function make () : self
	{
		return new static();
	}
}