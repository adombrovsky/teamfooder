<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('meal_categories', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('title');
            $table->string('url');
            $table->integer('created_at');
            $table->integer('updated_at');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('meal_categories', function(Blueprint $table)
		{
            $table->drop();
		});
	}

}
