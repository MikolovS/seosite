<?php
declare( strict_types = 1 );

namespace App\Services\Config\lib\Interfaces;

/**
 * Interface ConfigGetter
 * @package App\Services\Config\lib\Interfaces
 */
interface ConfigGetter
{
	/**
	 * @param string $domain
	 * @return array
	 */
	public function getDbConfigByDomain (string $domain) : array;

	/**
	 * @param string $domain
	 * @return string
	 */
	public function getSiteLanguage (string $domain) : string;
}