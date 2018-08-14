<?php
declare( strict_types = 1 );

use Illuminate\Database\Seeder;
use seo_db\Models\Category;

/**
 * Class CategoriesSeeder
 */
class CategoriesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run () : void
	{
		factory(Category::class, 'news')->create();

		factory(Category::class, 'root', 5)->create()->each(function (Category $category){
			factory(Category::class, 2)->create()->each(function (Category $subCat) use ($category){
				$subCat->appendToNode($category)->save();
				$subCat->children()->createMany(factory(Category::class, 3)->make()->toArray());
			});
		});
	}
}
