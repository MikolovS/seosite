<?php
declare( strict_types = 1 );

namespace App\Services\Config\lib\Interfaces;

use App\Services\Config\lib\Classes\DBConfigs;

/**
 * Interface ConfigGetter
 * @package App\Services\Config\lib\Interfaces
 */
interface ConfigGetter
{
	/**
	 * @param string $domain
	 * @return DBConfigs
	 */
	public function getDbConfigByDomain (string $domain) : DBConfigs;

	/**
	 * @param string $domain
	 * @return string
	 */
	public function getSiteLanguage (string $domain) : string;
}