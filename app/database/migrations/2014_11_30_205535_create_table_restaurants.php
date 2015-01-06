<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRestaurants extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('title');
            $table->string('alias');
            $table->string('url');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->unique('alias');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('restaurants', function(Blueprint $table)
		{
            $table->drop();
		});
	}

}
