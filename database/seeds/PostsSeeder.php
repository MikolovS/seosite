<?php
declare( strict_types = 1 );

use Illuminate\Database\Seeder;
use seo_db\Models\Post;

/**
 * Class PostsSeeder
 */
class PostsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 * @throws Exception
	 */
	public function run () : void
	{
		$content = '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur nisi dolorem, deserunt adipisci
                    optio odio consequatur iste tempore dolorum similique dolore! Modi culpa distinctio, a quaerat
                    suscipit delectus molestias, aliquam similique expedita commodi vel, quidem harum ut ullam sint
                    quos.
                </p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur nisi dolorem, deserunt adipisci
                    optio odio consequatur iste tempore dolorum similique dolore! Modi culpa distinctio, a quaerat
                    suscipit delectus molestias, aliquam similique expedita commodi vel, quidem harum ut ullam sint
                    quos.
                </p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur nisi dolorem, deserunt adipisci
                    optio odio consequatur iste tempore dolorum similique dolore! Modi culpa distinctio, a quaerat
                    suscipit delectus molestias, aliquam similique expedita commodi vel, quidem harum ut ullam sint
                    quos.
                </p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur nisi dolorem, deserunt adipisci
                    optio odio consequatur iste tempore dolorum similique dolore! Modi culpa distinctio, a quaerat
                    suscipit delectus molestias, aliquam similique expedita commodi vel, quidem harum ut ullam sint
                    quos.
                </p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur nisi dolorem, deserunt adipisci
                    optio odio consequatur iste tempore dolorum similique dolore! Modi culpa distinctio, a quaerat
                    suscipit delectus molestias, aliquam similique expedita commodi vel, quidem harum ut ullam sint
                    quos.
                </p>
                <h2>Lorem ipsum dolor sit amet consectetur.</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur nisi dolorem, deserunt adipisci
                    optio odio consequatur iste tempore dolorum similique dolore! Modi culpa distinctio, a quaerat
                    suscipit delectus molestias, aliquam similique expedita commodi vel, quidem harum ut ullam sint
                    quos.
                </p>
                <figure>
                    <img src="https://fashion.hola.com/imagenes/tendencias/2018072465484/zara-comprar-online-mejor-dia/0-270-555/zara-lookbook-z.jpg"
                         alt="alt">
                    <figcaption>© Getty Images</figcaption>
                </figure>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur nisi dolorem, deserunt adipisci
                    optio odio consequatur iste tempore dolorum similique dolore! Modi culpa distinctio, a quaerat
                    suscipit delectus molestias, aliquam similique expedita commodi vel, quidem harum ut ullam sint
                    quos.
                </p>
                <h2>Lorem ipsum dolor sit amet consectetur.</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur nisi dolorem, deserunt adipisci
                    optio odio consequatur iste tempore dolorum similique dolore! Modi culpa distinctio, a quaerat
                    suscipit delectus molestias, aliquam similique expedita commodi vel, quidem harum ut ullam sint
                    quos.
                </p>
                <figure>
                    <img src="https://fashion.hola.com/imagenes/tendencias/2018072465484/zara-comprar-online-mejor-dia/0-270-555/zara-lookbook-z.jpg"
                         alt="alt">
                    <figcaption>© Getty Images</figcaption>
                </figure>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur nisi dolorem, deserunt adipisci
                    optio odio consequatur iste tempore dolorum similique dolore! Modi culpa distinctio, a quaerat
                    suscipit delectus molestias, aliquam similique expedita commodi vel, quidem harum ut ullam sint
                    quos.
                </p>';

		$categories = \seo_db\Models\Category::all();

		$authorsIds = \seo_db\Models\Author::get()
		                                   ->pluck('id');

		foreach ($categories as $category) {
			$rand = random_int(5, 30);
			for ($i = 1; $i < $rand; $i++) {
				/** @var Post $post */
				$post = factory(Post::class)->make();
				$post->content = $content;
				$post->author_id = $authorsIds[ random_int(0, count($authorsIds) - 1) ];

				$category->mainPosts()
				         ->create($post->toArray());
			}
		}

		$posts = \seo_db\Models\Post::get();

		$posts->each(function ($post) use ($categories) {
			$randCats = array_rand($categories->keyBy('id')
			                                  ->toArray(), random_int(2, 4));
			$postCats = $categories->whereIn('id', $randCats)
			                       ->pluck('id')
			                       ->toArray();
			/** @var $post \seo_db\Models\Post */
			$post->categories()
			     ->sync($postCats);
		});
	}
}
