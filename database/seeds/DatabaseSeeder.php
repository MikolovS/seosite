<?php
declare( strict_types = 1 );

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run () : void
	{
		$this->setConfigs();

		$this->call(AuthorSeeder::class);
		$this->call(CategoriesSeeder::class);
		$this->call(PostsSeeder::class);
		$this->call(TagsSeeder::class);
	}

	/**
	 * setting default configs
	 */
	private function setConfigs() : void
	{
		$configName = \seo_db\Models\SeoSiteModel::getConnectionResolver()->getDefaultConnection();

		$configs = Config::get('database.connections.' . $configName);

		Config::set('database.connections.seo_site', $configs);
	}
}
