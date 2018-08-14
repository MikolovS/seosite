<?php
declare( strict_types = 1 );

namespace Tests\Unit\Services\Content;

use App\Services\Content\ContentService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use seo_db\Models\Post;
use seo_db\Models\Tag;
use Tests\TestCase;
use seo_db\Models\Category;
use App;

/**
 * Class ContentServiceTest
 * @package Tests\Unit\Services\Content
 */
class ContentServiceTest extends TestCase
{
	use DatabaseTransactions;
	/**
	 * @var ContentService
	 */
	private static $contentService;

	/**
	 *
	 */
	public function setUp () : void
	{
		parent::setUp();

		self::$contentService = App::make(ContentService::class);
	}

	/**
	 * @group ContentService
	 */
	public function testGetMainPageContent () : void
	{
		$categories = self::$contentService->getMainPageContent();

		/** @var Category $category */
		$category = $categories->random();
		$this->assertInstanceOf(Category::class, $category);

		$categoryArray = $category->toArray();
		$this->assertArrayHasKey('previewPost', $categoryArray);
		$this->assertArrayHasKey('main_posts', $categoryArray);

		/** @var Post $post */
		$post = $category->mainPosts->random();
		$this->assertInstanceOf(Post::class, $post);

		$postArray = $post->toArray();

		$this->assertArrayHasKey('author', $postArray);
		$this->assertArrayHasKey('tags', $postArray);
	}

	/**
	 * @group ContentService
	 */
	public function testGetPostContent () : void
	{
		$post = factory(Post::class, 'filled')->create();

		$result = self::$contentService->getPostContent($post)
		                               ->toArray();

		$this->assertArrayHasKey('author', $result);
		$this->assertArrayHasKey('tags', $result);
		$this->assertArrayHasKey('categories', $result);
	}

	/**
	 * @group ContentService
	 */
	public function testGetAmpContent () : void
	{
		$post = factory(Post::class, 'filled')->create();

		$result = self::$contentService->getAmpContent($post)
		                               ->toArray();

		$this->assertArrayHasKey('author', $result);
		$this->assertArrayHasKey('tags', $result);
		$this->assertArrayHasKey('categories', $result);
	}

	/**
	 * @group ContentService
	 */
	public function testGetPosts () : void
	{
		/** @var Category $category */
		$category = factory(Category::class)->create();

		$post = $category->mainPosts()
		                 ->create(factory(Post::class, 'with_author')
			                 ->make()
			                 ->toArray());

		$category->posts()
		         ->attach($post->id);

		$result = self::$contentService->getPosts($category);

		$this->assertEquals($result->getCollection()
		                           ->first(), $category->postsWithRelations()
		                                               ->first());
	}

	/**
	 * @group ContentService
	 */
	public function testGetPostsByCategoryAndTag () : void
	{
		/** @var Category $category */
		$category = factory(Category::class)->create();

		/** @var Post $post */
		$post = $category->mainPosts()
		                 ->create(factory(Post::class, 'with_author')
			                 ->make()
			                 ->toArray());

		/** @var Tag $tag */
		$tag = factory(Tag::class)->create();

		$category->tags()
		         ->attach($tag->id);
		$post->tags()
		     ->attach($tag->id);

		$result = self::$contentService->getPostsByCategoryAndTag($category, $tag);

		$post->load([
			'mainCategory' => function ($category) {
				return $category->get([
					'name',
					'slug',
				]);
			},
		]);

		$this->assertEquals($result->getCollection()
		                           ->first()
		                           ->toArray(), $post->toArray());
	}

	/**
	 * @group ContentService
	 */
	public function testGetNextPost () : void
	{
		/** @var Category $category */
		$category = factory(Category::class)->create();

		/** @var Post $post */
		$posts = $category->mainPosts()
		                  ->createMany(factory(Post::class, 'with_author', 2)
			                  ->make()
			                  ->toArray());

		$result = self::$contentService->getNextPost($category, $posts->sortBy('created_at')
		                                                              ->first());

		$this->assertContains($result->toArray(), $posts->toArray());
	}
}