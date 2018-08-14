<?php
declare( strict_types = 1 );

namespace Tests\Unit\Services\BreadCrumbs;

use App\Services\BreadCrumbs\BreadCrumbsService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use seo_db\Models\Author;
use seo_db\Models\Category;
use seo_db\Models\Post;
use Tests\TestCase;
use App;

/**
 * Class BreadCrumbsServiceTest
 * @package Tests\Unit\Services\BreadCrumbs
 */
class BreadCrumbsServiceTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * @var BreadCrumbsService
	 */
	private static $breadCrumbsService;

	/**
	 *
	 */
	public function setUp () : void
	{
		parent::setUp();

		self::$breadCrumbsService = App::make(BreadCrumbsService::class);
	}

	/**
	 * @group BreadCrumbsService
	 */
	public function testGetForCategory () : void
	{
		/** @var Category $category */
		$category = factory(Category::class, 'child')->make();

		$breadCrumbs = self::$breadCrumbsService->getForCategory($category);

		$breadCrumbsArray = $breadCrumbs->toArray();

		$this->assertArrayHasKey('paths', $breadCrumbsArray);
		$this->assertArrayHasKey('current_page', $breadCrumbsArray);


		$this->assertEquals([
			'name' => $category->name,
			'url'  => url($category->slug),
		], $breadCrumbs->getCurrentPage()
		               ->toArray());
	}

	/**
	 * @group BreadCrumbsService
	 */
	public function testGetForPost () : void
	{
		$post = factory(Post::class, 'filled')->make();

		$breadCrumbs = self::$breadCrumbsService->getForPost($post);

		$breadCrumbsArray = $breadCrumbs->toArray();

		$this->assertArrayHasKey('paths', $breadCrumbsArray);
		$this->assertArrayHasKey('current_page', $breadCrumbsArray);

		$this->assertEquals([
			'name' => $post->h1,
			'url'  => url($post->slug),
		], $breadCrumbs->getCurrentPage()
		               ->toArray());
	}

	/**
	 * @group BreadCrumbsService
	 */
	public function testGetForAuthor () : void
	{
		/** @var Author $author */
		$author = factory(Author::class)->make();

		$breadCrumbs = self::$breadCrumbsService->getForAuthor($author);

		$breadCrumbsArray = $breadCrumbs->toArray();

		$this->assertArrayHasKey('paths', $breadCrumbsArray);
		$this->assertArrayHasKey('current_page', $breadCrumbsArray);

		$this->assertEquals([
			'name' => $author->full_name,
			'url'  => url($author->slug),
		], $breadCrumbs->getCurrentPage()
		               ->toArray());
	}

	/**
	 * @group BreadCrumbsService
	 */
	public function testGetForAuthorsPage () : void
	{
		$breadCrumbs = self::$breadCrumbsService->getForAuthorsPage();

		$breadCrumbsArray = $breadCrumbs->toArray();

		$this->assertArrayHasKey('paths', $breadCrumbsArray);
		$this->assertArrayHasKey('current_page', $breadCrumbsArray);

		$this->assertEquals([
			'name' => 'Authors',
			'url' => url('authors'),
		], $breadCrumbs->getCurrentPage()
		               ->toArray());
	}
}