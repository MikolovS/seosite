<?php
declare( strict_types = 1 );


namespace Tests\Unit\Services\Config\Factories;

use Tests\Library\Factories\AbstractFactory;


/**
 * Class LanguagesFactory
 * @package Tests\Unit\Services\Config\Factories
 */
class LanguagesFactory extends AbstractFactory
{
	public static $languages = [
		'Russian'    => 'ru',
		'French'     => 'fr',
		'English'    => 'en',
		'Spanish'    => 'es',
		'Polish'     => 'pl',
		'Portuguese' => 'pt',
	];

	/**
	 * @return array|mixed
	 */
	public function produce ()
	{
		$count = random_int(1, \count(self::$languages));

		$langArray = [];

		$languages = self::$languages;

		shuffle($languages);

		$languages = \array_slice($languages, -$count);

		foreach ($languages as $language) {
			$langArray[ $language ] = $this->generateDomainsArray();
		}

		if ($this->requiredAttribute) {
			$language                 = array_rand($langArray, 1);
			$langArray[ $language ][] = $this->requiredAttribute;
		}

		return $langArray;
	}

	/**
	 * @return string
	 */
	private function makeDomain () : string
	{
		return convertDomain($this->faker->domainName);
	}

	/**
	 * @return array
	 */
	private function generateDomainsArray () : array
	{
		$domains = [];

		$count = random_int(1, 10);

		for ($i = 0; $i < $count; $i++) {
			$domains[] = $this->makeDomain();
		}

		return $domains;
	}
}