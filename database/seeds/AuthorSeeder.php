<?php
declare( strict_types = 1 );

use Illuminate\Database\Seeder;
use \seo_db\Models\Author;

/**
 * Class AuthorSeeder
 */
class AuthorSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run () : void
	{
		factory(Author::class, 'is_default')->create();
		factory(Author::class, 5)->create();
	}
}
