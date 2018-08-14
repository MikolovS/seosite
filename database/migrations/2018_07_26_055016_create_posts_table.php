<?php
declare( strict_types = 1 );

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePostsTable
 */
class CreatePostsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up () : void
	{
		Schema::create('posts', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('category_id')->comment = 'Основная категория поста';
			$table->text('meta')->comment           = 'Все необходимые метатэги';
			$table->longText('content');
			$table->longText('amp_content')->comment = 'АМП контент для гугла';
			$table->string('h1')->comment            = 'Заголовок для статьи';
			$table->string('slug');
			$table->string('preview');
			$table->string('description');
			$table->integer('author_id');
			$table->timestamps();
			$table->softDeletes();

			$table->unique([
				'category_id',
				'slug',
			]);

			$table->foreign('category_id')
			      ->references('id')
			      ->on('categories');

			$table->foreign('author_id')
			      ->references('id')
			      ->on('authors');
		});

		DB::statement("COMMENT ON TABLE posts IS 'Таблица со статьями'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down () : void
	{
		Schema::dropIfExists('posts');
	}
}
