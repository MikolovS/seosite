<?php
declare( strict_types = 1 );

use Faker\Generator as Faker;
use seo_db\Models\Post;
use seo_db\Models\Category;
use seo_db\Models\Author;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/** @var $factory Illuminate\Database\Eloquent\Factory */

$factory->define(Post::class, function (Faker $faker) {

	$h1 = $faker->text(40);

	$previews = [
		'https://mejorconsalud.com/wp-content/uploads/2018/06/drogas-273x190.jpg',
		'https://mejorconsalud.com/wp-content/uploads/2018/06/alcohol-feto-137x100.jpg',
		'https://mejorconsalud.com/wp-content/uploads/2018/06/placenta-feto-embarazo-137x100.jpg',
		'https://mejorconsalud.com/wp-content/uploads/2018/07/semillas-461x308.jpg',
	];

	return [
		'content'     => $faker->text,
		'meta'        => '<meta description="meta" content="post-meta">',
		'amp_content' => $faker->text,
		'h1'          => $h1,
		'slug'        => str_slug($h1),
		'preview'     => $previews[ random_int(0, count($previews) - 1) ],
		'description' => $faker->text(100),
		'created_at' => $faker->dateTime(),
		'updated_at' => $faker->dateTime(),
		'deleted_at' => null,
	];
});

$factory->defineAs(Post::class, 'with_author', function (Faker $faker) use ($factory) {
	$post = $factory->raw(Post::class);

	return array_merge($post, [
		'author_id'   => function () {
			return factory(Author::class)->create()->id;
		},
	]);
});

$factory->defineAs(Post::class, 'with_category', function (Faker $faker) use ($factory) {
	$post = $factory->raw(Post::class);

	return array_merge($post, [
		'category_id'   => function () {
			return factory(Category::class, 'child')->create()->id;
		},
	]);
});

$factory->defineAs(Post::class, 'filled', function (Faker $faker) use ($factory) {
	$post = $factory->raw(Post::class);

	return array_merge($post, [
		'category_id'   => $factory->raw(Post::class, [], 'with_category')['category_id'],
		'author_id'   => $factory->raw(Post::class, [], 'with_author')['author_id'],
	]);
});
