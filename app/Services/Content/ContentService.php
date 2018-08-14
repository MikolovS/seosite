<?php
declare( strict_types = 1 );

namespace App\Services\Content;

use App\Repositories\AuthorRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Services\Advertising\AdvertisingService;
use App\Services\Embed\EmbedService;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use seo_db\Models\Category;
use seo_db\Models\Post;
use seo_db\Models\SeoSiteModel;
use seo_db\Models\Tag;

/**
 * Class ContentService
 * @package App\Services
 */
class ContentService
{
	public const PAGINATE = 10;

	/**
	 * @var CategoryRepository
	 */
	protected $categoryRep;

	/**
	 * @var AuthorRepository
	 */
	protected $authorRep;

	/**
	 * @var PostRepository
	 */
	protected $postRep;

	/**
	 * ContentService constructor.
	 * @param CategoryRepository $categoryRep
	 * @param AuthorRepository   $authorRepository
	 * @param PostRepository     $postRepository
	 */
	public function __construct (
		CategoryRepository $categoryRep,
		AuthorRepository $authorRepository,
		PostRepository $postRepository)
	{
		$this->categoryRep = $categoryRep;
		$this->authorRep   = $authorRepository;
		$this->postRep     = $postRepository;
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getMainPageContent () : Collection
	{
		$categories = $this->categoryRep->getMainCategories();

		$categories->transform(function (Category $category) {
			/** @var $category Category */
			$category = $category->load([
				'mainPosts' => function ($posts) {
					/** @var $posts Builder */
					return $posts->with([
						'mainCategory',
						'author',
						'tags',
					])
					             ->orderBy('created_at')
					             ->take(3);
				},
			]);

			$category->previewPost = $category->mainPosts->shift();

			return $category;
		});

		return $categories;
	}

	/**
	 * @param Post $post
	 * @return Post
	 */
	public function getPostContent (Post $post) : Post
	{
		$post->load([
			'author',
			'tags',
			'categories',
		]);

		$content       = AdvertisingService::prepareContentWithAdvertising($post->content);
		$post->content = EmbedService::replace($content);

		return $post;
	}

	/**
	 * @param Post $post
	 * @return Post
	 */
	public function getAmpContent (Post $post) : Post
	{
		$post->load([
			'author',
			'tags',
			'categories',
		]);

		$post->content = AdvertisingService::prepareContentWithAdvertising($post->amp_content, true);

		return $post;
	}

	/**
	 * @param SeoSiteModel $model
	 * @return LengthAwarePaginator
	 */
	public function getPosts (SeoSiteModel $model) : LengthAwarePaginator
	{
		/** @noinspection PhpUndefinedMethodInspection */
		return $model->postsWithRelations()
		             ->paginate(self::PAGINATE);
	}


	/**
	 * @param Category $category
	 * @param Tag      $tag
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|LengthAwarePaginator
	 */
	public function getPostsByCategoryAndTag (Category $category, Tag $tag) : LengthAwarePaginator
	{
		return $this->postRep->getByCategoryAndTag($category, $tag)
		                     ->paginate(self::PAGINATE);
	}

	/**
	 * @param Category $category
	 * @param Post     $post
	 * @return mixed
	 */
	public function getNextPost (Category $category, Post $post)
	{
		return $this->categoryRep->getNextPost($category, $post);
	}

	/**
	 * @return Collection
	 */
	public function getAuthorsPageContent () : Collection
	{
		return $this->authorRep->getForPage();
	}

	/**
	 * @return Collection
	 */
	public function getSliderContent () : Collection
	{
		return $this->postRep->getSliderContent();
	}

	/**
	 * @return Collection
	 */
	public function getNewsSliderContent () : Collection
	{
		return $this->categoryRep->getNewsForSlider();
	}

	/**
	 * @param Category $category
	 * @return Collection
	 */
	public function getCategoryTags (Category $category) : Collection
	{
		$tagsFilter           = $this->categoryRep->getCategoryTags($category);
		$tagsFilter->category = $category;

		return $tagsFilter;
	}
}