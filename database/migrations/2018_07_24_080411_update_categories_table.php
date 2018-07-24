<?php
declare( strict_types = 1 );

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class UpdateCategoriesTable
 */
class UpdateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('categories');

	    Schema::create('categories', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name')
		          ->unique();
		    $table->string('slug')
		          ->unique();

		    $table->nestedSet();

		    $table->timestamps();
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('categories');
    }
}
