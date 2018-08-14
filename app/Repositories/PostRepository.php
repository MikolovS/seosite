<?php
declare( strict_types = 1 );

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use seo_db\Models\Category;
use seo_db\Models\Post;
use seo_db\Models\Tag;

/**
 * Class PostRepository
 * @package App\Repositories
 */
class PostRepository
{
	/**
	 * @var Post
	 */
	protected $model;

	/**
	 * CategoryRepository constructor.
	 * @param Post $post
	 */
	public function __construct (Post $post)
	{
		$this->model = $post;
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getSliderContent () : Collection
	{
		return $this->model::orderBy('created_at')
		                   ->take(6)
		                   ->get();
	}

	/**
	 * @param Category $category
	 * @param Tag      $tag
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function getByCategoryAndTag (Category $category, Tag $tag) : \Illuminate\Database\Eloquent\Builder
	{
		return $this->model::whereCategoryId($category->id)
		                   ->whereHas('tags', function ($tagRel) use ($tag) {
			                   $tagRel->whereId($tag->id);
		                   })
		                   ->with([
			                   'mainCategory' => function ($category) {
				                   return $category->get([
					                   'name',
					                   'slug',
				                   ]);
			                   },
		                   ]);
	}
}