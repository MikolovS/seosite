<?php
declare( strict_types = 1 );

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePostTagTable
 */
class CreatePostTagTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up () : void
	{
		Schema::create('post_tag', function (Blueprint $table) {
			$table->integer('post_id');
			$table->integer('tag_id');

			$table->foreign('post_id')
			      ->references('id')
			      ->on('posts')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');

			$table->foreign('tag_id')
			      ->references('id')
			      ->on('tags')
			      ->onUpdate('cascade')
			      ->onDelete('cascade');
		});

		DB::statement("COMMENT ON TABLE post_tag IS 'Связь между постами и тагами'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down () : void
	{
		Schema::dropIfExists('post_tag');
	}
}
