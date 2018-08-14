<?php
declare( strict_types = 1 );

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePostCategoryTable
 */
class CreatePostCategoryTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up () : void
	{
		Schema::create('post_category', function (Blueprint $table) {
			$table->integer('post_id');
			$table->integer('category_id');

			$table->foreign('category_id')
			      ->references('id')
			      ->on('categories');

			$table->foreign('post_id')
			      ->references('id')
			      ->on('posts');
		});

		DB::statement("COMMENT ON TABLE post_category IS 'Таблица отношений поста к категориям'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down () : void
	{
		Schema::dropIfExists('post_category');
	}
}
