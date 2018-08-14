<?php
declare( strict_types = 1 );

namespace Tests\Unit\Services\Cache;

use App;
use App\Services\CacheService\CacheService;
use seo_db\Models\Author;
use Tests\TestCase;

/**
 * Class CacheServiceTest
 * @package Tests\Unit\Services\Cache
 */
class CacheServiceTest extends TestCase
{
	/**
	 * @var CacheService
	 */
	private static $cacheService;

	/**
	 *
	 */
	public function setUp () : void
	{
		parent::setUp();

		self::$cacheService = App::make(CacheService::class);
	}

	/**
	 * @group CacheServiceTest
	 */
	public function testGet() : void
	{
		$author = factory(Author::class)->make();

		$result = self::$cacheService->get($author->slug, function () use($author){
			return $author;
		});

		$this->assertEquals($author, $result);
	}
}