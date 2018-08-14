<?php
declare( strict_types = 1 );

use Faker\Generator as Faker;
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

$factory->define(Author::class, function (Faker $faker) {

	return [
			'first_name'  => $faker->firstName,
			'last_name'   => $faker->lastName,
			'slug'        => $faker->slug,
			'avatar'      => 'https://i.pinimg.com/236x/43/96/85/43968557a62d936982363e4a9af054ea--cindy-kimberly-photoshoot-cindy-kimberly-instagram.jpg',
			'is_default'  => false,
			'position'    => $faker->word,
			'office'      => $faker->city,
			'phone'       => $faker->phoneNumber,
			'partnership' => $faker->dateTimeInInterval()->format('y-m-d'),
			'twitter'     => 'Jay_Bavishi',
			'mail'        => $faker->email,
			'facebook'    => 'pugavki',
			'instagram'   => 'sofiya_wim',
			'linkedin'    => 'sofiia-mashchenko-6a663b134',
			'google'      => '100705959793436779289',
			'pinterest'   => 'pinterest',
			'rss'         => 'view_pubs',
			'description' => $faker->text(250),
	];
});

$factory->defineAs(Author::class, 'is_default', function (Faker $faker) use ($factory){

	$author =  $factory->raw(Author::class);

	return array_merge($author, ['is_default' => true]);
});
