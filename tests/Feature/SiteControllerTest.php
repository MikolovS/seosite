<?php
declare( strict_types = 1 );

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestResponse;
use seo_db\Models\Author;
use seo_db\Models\Category;
use seo_db\Models\Post;
use seo_db\Models\Tag;
use Tests\TestCase;

/**
 * Class SiteControllerTest
 * @package Tests\Feature
 */
class SiteControllerTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * @param string $url
	 * @return \Illuminate\Foundation\Testing\TestResponse
	 */
	private function getSuccessResponse (string $url) : TestResponse
	{
		$response = $this->get($url);

		$response->assertStatus(200);

		return $response;
	}

	/**
	 * @group SiteController
	 */
	public function testIndex () : void
	{
		$this->getSuccessResponse('/');
	}

	/**
	 * @group SiteController
	 */
	public function testShowPostPage () : void
	{
		/** @var Category $category */
		$category = factory(Category::class)->create();

		/** @var Post $post */
		$post = $category->mainPosts()
		                 ->create(factory(Post::class, 'with_author')
			                 ->make()
			                 ->toArray());

		$response = $this->getSuccessResponse('/' . $category->slug . '/' . $post->slug);

		$response->assertSeeText($post->h1);
	}

	/**
	 * @group SiteController
	 */
	public function testShowAmpPostPage () : void
	{
		/** @var Category $category */
		$category = factory(Category::class)->create();

		/** @var Post $post */
		$post = $category->mainPosts()
		                 ->create(factory(Post::class, 'with_author')
			                 ->make()
			                 ->toArray());

		$response = $this->getSuccessResponse('amp/' . $category->slug . '/' . $post->slug);

		$response->assertSeeText($post->h1);
	}

	/**
	 * @group SiteController
	 */
	public function testShowCategoryPage () : void
	{
		/** @var Category $category */
		$category = factory(Category::class)->create();

		/** @var Post $post */
		$posts = $category->mainPosts()
		                  ->createMany(factory(Post::class, 'with_author', 2)
			                  ->make()
			                  ->toArray());

		$category->posts()
		         ->sync($posts->pluck('id'));

		$response = $this->getSuccessResponse($category->slug);

		$posts->each(function (Post $post) use ($response) {
			$response->assertSeeText($post->h1);
		});
	}

	/**
	 * @group SiteController
	 */
	public function testShowTagPage () : void
	{
		/** @var Tag $tag */
		$tag = factory(Tag::class)->create();

		$posts = factory(Post::class, 'filled', 2)->create();
		$posts->each(function (Post $post) use ($tag) {
			$post->tags()
			     ->attach($tag->id);
		});

		$response = $this->getSuccessResponse('tag/' . $tag->slug);

		$posts->each(function (Post $post) use ($response) {
			$response->assertSeeText($post->h1);
		});
	}

	/**
	 * @group SiteController
	 */
	public function testShowCategoryTagsPage () : void
	{
		/** @var Category $category */
		$category = factory(Category::class)->create();

		/** @var Post $post */
		$posts = $category->mainPosts()
		                  ->createMany(factory(Post::class, 'with_author', 2)
			                  ->make()
			                  ->toArray());

		$category->posts()
		         ->sync($posts->pluck('id'));

		/** @var Tag $tag */
		$tag = factory(Tag::class)->create();

		$category->tags()
		         ->attach($tag->id);

		$posts->each(function (Post $post) use ($tag) {
			$post->tags()
			     ->attach($tag->id);
		});

		$response = $this->getSuccessResponse('filter/' . $category->slug . '/' . $tag->slug);

		$posts->each(function (Post $post) use ($response) {
			$response->assertSeeText($post->h1);
		});
	}

	/**
	 * @group SiteController
	 */
	public function testShowAuthorPostsPage () : void
	{
		/** @var Author $author */
		$author = factory(Author::class)->create();

		$posts = $author->posts()
		                ->createMany(factory(Post::class, 'with_category', 3)
			                ->make()
			                ->toArray());

		$response = $this->getSuccessResponse('authors/' . $author->slug);

		$response->assertSeeText($author->full_name);

		$posts->each(function (Post $post) use ($response) {
			$response->assertSeeText($post->h1);
		});
	}

	/**
	 * @group SiteController
	 */
	public function testShowAuthorsPage () : void
	{
		$authors = factory(Author::class, 2)->create();

		$response = $this->getSuccessResponse('authors');

		$authors->each(function (Author $post) use ($response) {
			$response->assertSeeText($post->full_name);
		});
	}
}
