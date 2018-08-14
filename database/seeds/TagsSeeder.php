<?php
declare( strict_types = 1 );

use Illuminate\Database\Seeder;
use seo_db\Models\Post;
use seo_db\Models\Tag;
use seo_db\Models\Category;

/**
 * Class TagsSeeder
 */
class TagsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run () : void
	{
		$tags  = factory(Tag::class, 50)->create();
		$posts = Post::get();

		$posts->each(function ($post) use ($tags) {
			$randTags = array_rand($tags->keyBy('id')
			                            ->toArray(), random_int(1, 7));
			$postTags = $tags->whereIn('id', $randTags)
			                 ->pluck('id')
			                 ->toArray();
			/** @var $post \seo_db\Models\Post */
			$post->tags()
			     ->sync($postTags);
		});

		$categories = Category::get();

		$categories->each(function ($category) use ($tags) {
			$randTags     = array_rand($tags->keyBy('id')
			                                ->toArray(), random_int(2, 5));
			$categoryTags = $tags->whereIn('id', $randTags)
			                     ->pluck('id')
			                     ->toArray();
			/** @var $category Category */
			$category->tags()
			         ->sync($categoryTags);
		});
	}
}
