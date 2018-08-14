<?php
declare( strict_types = 1 );

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreteCategoryTagTable
 */
class CreteCategoryTagTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up () : void
	{
		Schema::create('category_tag', function (Blueprint $table) {
			$table->integer('category_id');
			$table->integer('tag_id');

			$table->foreign('category_id')
			      ->references('id')
			      ->on('categories')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');

			$table->foreign('tag_id')
			      ->references('id')
			      ->on('tags')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');
		});

		DB::statement("COMMENT ON TABLE category_tag IS 'Связь между категориями и тагами'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down () : void
	{
		Schema::dropIfExists('category_tag');
	}
}
