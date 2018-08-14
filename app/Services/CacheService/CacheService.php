<?php
declare( strict_types = 1 );

namespace App\Services\CacheService;

use Illuminate\Cache\CacheManager;

/**
 * Class CacheService
 * @package App\Services\CacheService
 */
class CacheService
{
	public const CACHE_TIME = 10;

	/**
	 * @var CacheManager
	 */
	protected $manager;

	/**
	 * CacheService constructor.
	 * @param CacheManager $cache
	 */
	public function __construct (CacheManager $cache)
	{
		$this->manager = $cache;
	}

	/**
	 * @param string   $cacheKey
	 * @param callable $function
	 * @param int      $cacheTime
	 * @return mixed
	 */
	public function get (string $cacheKey, callable $function, int $cacheTime = self::CACHE_TIME)
	{
		return $this->manager->remember($this->getSiteCacheKey($cacheKey), $cacheTime, $function);
	}

	/**
	 * @param string $cacheKey
	 * @return string
	 */
	private function getSiteCacheKey (string $cacheKey) : string
	{
		return \DB::getName() . $cacheKey;
	}
}