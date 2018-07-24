<?php
declare( strict_types = 1 );

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use ReflectionObject;

/**
 * Class TestCase
 * @package Tests
 */
abstract class TestCase extends BaseTestCase
{
	use CreatesApplication;

	/**
	 * @param        $object
	 * @param string $method
	 * @param null   $arguments
	 * @return mixed
	 */
	public function invokeMethod ($object, string $method, $arguments = null)
	{
		$reflector = new ReflectionObject($object);
		/** @noinspection CallableParameterUseCaseInTypeContextInspection */
		$method = $reflector->getMethod($method);
		$method->setAccessible(true);

		return $method->invoke($object, $arguments);
	}
}
