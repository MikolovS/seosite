<?php
declare( strict_types = 1 );

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class UpdateCategoriesTable
 */
class CreateCategoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up () : void
	{
		Schema::create('categories', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('slug')->unique();
			$table->integer('order')->comment                   = 'Порядок отображения';
			$table->boolean('display')->default(false)->comment = 'Нужно ли отображать на сайте';
			$table->text('description')->comment                = 'Описание';
			$table->string('h1')->comment                       = 'Заголовок';
			$table->string('preview')->comment                  = 'Превью';
			$table->text('meta')->comment                       = 'Список метатегов';

			$table->nestedSet();
			$table->softDeletes();
		});

		DB::statement("COMMENT ON TABLE categories IS 'Категории постов, используется так-же для построения Nav-bar'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down () : void
	{
		Schema::dropIfExists('categories');
	}
}
