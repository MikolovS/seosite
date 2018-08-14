<?php
declare( strict_types = 1 );

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAuthorsTable
 */
class CreateAuthorsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up () : void
	{
		Schema::create('authors', function (Blueprint $table) {
			$table->increments('id');
			$table->string('slug')
			      ->unique();
			$table->string('first_name');
			$table->string('last_name');
			$table->text('description');
			$table->text('meta')->default('');
			$table->string('mail')
			      ->nullable()->comment            = 'Почта';
			$table->string('twitter')
			      ->nullable()->comment            = 'Твиттер акаунт';
			$table->string('google')
			      ->nullable()->comment            = 'Google plus акаунт';
			$table->string('facebook')
			      ->nullable()->comment            = 'ФБ акаунт';
			$table->string('pinterest')
			      ->nullable()->comment            = 'Pinterest акаунт';
			$table->string('linkedin')
			      ->nullable()->comment            = 'LinkedIn акаунт';
			$table->string('instagram')
			      ->nullable()->comment            = 'Instagram акаунт';
			$table->string('rss')
			      ->nullable()->comment            = 'RSS лента';
			$table->string('position')->comment    = 'Должность';
			$table->string('office')->comment      = 'Информация об оффисе';
			$table->string('phone')->comment       = 'Номер телефона';
			$table->string('partnership')->comment = 'Сотрудничество';
			$table->string('avatar');
			$table->boolean('is_default')
			      ->deafault(false)->comment = 'Автор по умолчанию';
			$table->softDeletes();
		});

		DB::statement("COMMENT ON TABLE authors IS 'Таблица с авторами статей'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down () : void
	{
		Schema::dropIfExists('authors');
	}
}
