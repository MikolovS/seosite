<?php
declare( strict_types = 1 );

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use seo_db\Models\Category;
use seo_db\Models\Post;

/**
 * Class CategoryRepository
 * @package App\Repositories
 */
class CategoryRepository
{
	/**
	 * News category slug
	 */
	public const NEWS = 'news';

	/**
	 * @var Category
	 */
	protected $model;

	/**
	 * CategoryRepository constructor.
	 * @param Category $category
	 */
	public function __construct (Category $category)
	{
		$this->model = $category;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getMainCategories () : Collection
	{
		return $this->model::whereDisplay(true)
		                   ->whereNull('parent_id')
		                   ->whereHas('mainPosts')
		                   ->orderBy('order')
		                   ->get();
	}

	/**
	 * @param Category $category
	 * @param Post     $post
	 * @return mixed
	 */
	public function getNextPost (Category $category, Post $post)
	{
		return $category->mainPosts()
		                ->where('created_at', '>', $post->created_at->toDateTimeString())
		                ->orderBy('created_at', 'asc')
		                ->first();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getNewsForSlider () : Collection
	{
		$news = $this->model::whereSlug(self::NEWS)
		                    ->first();

		if ($news === null)
			$posts = new Collection();
		else
			$posts = $news->postsWithRelations()
			              ->orderBy('created_at', 'asc')
			              ->take(6)
			              ->get();

		return $posts;
	}

	/**
	 * @return \Kalnoy\Nestedset\Collection
	 */
	public function getCategoriesForNavBar () : \Kalnoy\Nestedset\Collection
	{
		return $this->model::whereDisplay(true)
		                   ->orderBy('order')
		                   ->get()
		                   ->toTree();
	}

	/**
	 * @param Category $category
	 * @return Collection
	 */
	public function getCategoryTags (Category $category) : Collection
	{
		return $category->tags()
		                ->orderBy('name')
		                ->get();
	}
}