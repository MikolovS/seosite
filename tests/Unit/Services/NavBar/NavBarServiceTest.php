<?php
declare( strict_types = 1 );

namespace Tests\Unit\Services\NavBar;

use App;
use App\Services\NavBar\NavBarService;
use seo_db\Models\Category;
use Tests\TestCase;

/**
 * Class NavBarServiceTest
 * @package Tests\Unit\Services\NavBar
 */
class NavBarServiceTest extends TestCase
{
	/**
	 * @var NavBarService
	 */
	private static $navBarService;

	/**
	 *
	 */
	public function setUp () : void
	{
		parent::setUp();

		self::$navBarService = App::make(NavBarService::class);
	}

	/**
	 * @group NavBarService
	 */
	public function testGetCategoryTree () : void
	{
		$result = self::$navBarService->getCategoryTree();

		/** @var Category $category */
		$category = $result->random();

		$this->assertInstanceOf(Category::class, $category);
		$this->assertArrayHasKey('children', $category->toArray());
	}
}