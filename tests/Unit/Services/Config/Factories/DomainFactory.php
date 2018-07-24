<?php
declare( strict_types = 1 );

namespace Tests\Unit\Services\Config\Factories;

use Tests\Library\Factories\AbstractFactory;

/**
 * Class DomainFactory
 * @package Tests\Unit\Services\Config\Factories
 */
class DomainFactory extends AbstractFactory
{
	/**
	 * @return string
	 */
	public function produce () : string
	{
		$domain = $this->faker->domainName;

		return convertDomain($domain);
	}
}