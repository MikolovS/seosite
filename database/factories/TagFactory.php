<?php
declare( strict_types = 1 );

use Faker\Generator as Faker;
use seo_db\Models\Tag;

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

$factory->define(Tag::class, function (Faker $faker) {
	$name = $faker->name;
	return [
		'name' => $name,
		'slug' => str_slug($name),
	];
});