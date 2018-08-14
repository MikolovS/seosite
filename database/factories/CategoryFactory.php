<?php
declare( strict_types = 1 );

use Faker\Generator as Faker;
use seo_db\Models\Category;

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

$factory->define(Category::class, function (Faker $faker) {
	$name = $faker->name;

	return [
		'name'        => $name,
		'slug'        => str_slug($name),
		'order'       => random_int(1, 999),
		'display'     => true,
		'description' => $faker->text(50),
		'h1'          => $faker->text(25),
		'preview'     => $faker->text(25),
		'meta'        => '<meta content="category-' . random_int(1, 999) . '"/>',
	];
});


$factory->defineAs(Category::class, 'root', function (Faker $faker) use ($factory) {

	$category = $factory->raw(Category::class);

	return array_merge($category, ['parent_id' => null]);
});

$factory->defineAs(Category::class, 'child', function (Faker $faker) use ($factory) {
	$category = $factory->raw(Category::class);

	return array_merge($category, [
		'parent_id' => function () {
			return factory(Category::class, 'root')->create()->id;
		},
	]);
});

$factory->defineAs(Category::class, 'news', function (Faker $faker) use ($factory) {
	$category = $factory->raw(Category::class, [], 'root');

	$category[ 'order' ] = 1;
	$category[ 'name' ]  = 'News';
	$category[ 'slug' ]  = str_slug($category[ 'name' ]);

	return $category;
});
