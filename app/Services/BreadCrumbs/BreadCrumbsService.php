<?php
declare( strict_types = 1 );

namespace App\Services\BreadCrumbs;

use App\Services\BreadCrumbs\lib\Items\BreadCrumbLeafItem;
use App\Services\BreadCrumbs\lib\Items\BreadCrumbsItem;
use App\Services\BreadCrumbs\lib\Mappers\BreadCrumbsLeafMapper;
use App\Services\BreadCrumbs\lib\Mappers\BreadCrumbsMapper;
use App\Services\CacheService\CacheService;
use Illuminate\Support\Collection;
use seo_db\Models\Author;
use seo_db\Models\Category;
use seo_db\Models\Post;

/**
 * Class BreadCrumbsService
 * @package App\Services\BreadCrumbs
 */
class BreadCrumbsService
{
	public const CACHE_TIME = 10;

	/**
	 * @var BreadCrumbLeafItem
	 */
	protected $breadCrumbLeafMapper;

	/**
	 * @var BreadCrumbsMapper
	 */
	protected $breadCrumbsMapper;

	/**
	 * @var CacheService
	 */
	protected $cache;

	/**
	 * BreadCrumbsService constructor.
	 * @param BreadCrumbsLeafMapper $breadCrumbLeafMapper
	 * @param BreadCrumbsMapper     $breadCrumbsMapper
	 * @param CacheService          $cache
	 */
	public function __construct (
		BreadCrumbsLeafMapper $breadCrumbLeafMapper,
		BreadCrumbsMapper $breadCrumbsMapper,
		CacheService $cache)
	{
		$this->breadCrumbLeafMapper = $breadCrumbLeafMapper;
		$this->breadCrumbsMapper    = $breadCrumbsMapper;
		$this->cache                = $cache;
	}

	/**
	 * @return BreadCrumbLeafItem
	 */
	private function getHomeBreadCrumb () : BreadCrumbLeafItem
	{
		return $this->breadCrumbLeafMapper->map([
			'slug' => '',
			'name' => 'Home',
		]);
	}

	/**
	 * @param Category $category
	 * @return mixed
	 */
	private function getCategoryPaths (Category $category)
	{
		return $category->getAncestors()
		                ->map(function (Category $category) {
			                return $this->breadCrumbLeafMapper->map($category->toArray());
		                });
	}

	/**
	 * @param Collection $paths
	 * @param array      $currantPage
	 * @return BreadCrumbsItem
	 */
	private function breadCrumbs (Collection $paths, array $currantPage) : BreadCrumbsItem
	{
		return $this->breadCrumbsMapper->map([
			'paths'        => $paths,
			'current_page' => $this->breadCrumbLeafMapper->map($currantPage),
		]);
	}

	/**
	 * @param Category $category
	 * @return BreadCrumbsItem
	 */
	public function getForCategory (Category $category) : BreadCrumbsItem
	{
		$cacheKey = 'bc_cat_' . $category->slug;

		return $this->getFromCache($cacheKey, function () use ($category) {
			$paths = $this->getCategoryPaths($category)
			              ->prepend($this->getHomeBreadCrumb());

			return $this->breadCrumbs($paths, [
				'name' => $category->name,
				'slug' => $category->slug,
			]);
		});
	}

	/**
	 * @param Post $post
	 * @return BreadCrumbsItem
	 */
	public function getForPost (Post $post) : BreadCrumbsItem
	{
		$cacheKey = 'bc_post_' . $post->slug;

		return $this->getFromCache($cacheKey, function () use ($post) {
			$paths = $this->getCategoryPaths($post->mainCategory)
			              ->prepend($this->getHomeBreadCrumb())
			              ->push($this->breadCrumbLeafMapper->map($post->mainCategory->toArray()));

			return $this->breadCrumbs($paths, [
				'name' => $post->h1,
				'slug' => $post->slug,
			]);
		});
	}

	/**
	 * @param Author $author
	 * @return BreadCrumbsItem
	 */
	public function getForAuthor (Author $author) : BreadCrumbsItem
	{
		$cacheKey = 'bc_auth_' . $author->slug;

		return $this->getFromCache($cacheKey, function () use ($author) {
			$home    = $this->getHomeBreadCrumb();
			$authors = $this->breadCrumbLeafMapper->map([
				'slug' => 'authors',
				'name' => 'Authors',
			]);

			$paths = collect([
				$home,
				$authors,
			]);

			return $this->breadCrumbs($paths, [
				'name' => $author->fullName,
				'slug' => $author->slug,
			]);
		});
	}

	/**
	 * @return BreadCrumbsItem
	 */
	public function getForAuthorsPage () : BreadCrumbsItem
	{
		return $this->getFromCache('bc_auth_page', function () {
			$home  = $this->getHomeBreadCrumb();
			$paths = collect([$home]);

			return $this->breadCrumbs($paths, [
				'name' => 'Authors',
				'slug' => 'authors',
			]);
		});
	}

	/**
	 * @param $cacheKey
	 * @param $function
	 * @return mixed
	 */
	private function getFromCache (string $cacheKey, callable $function)
	{
		return $this->cache->get($cacheKey, $function, self::CACHE_TIME);
	}
}