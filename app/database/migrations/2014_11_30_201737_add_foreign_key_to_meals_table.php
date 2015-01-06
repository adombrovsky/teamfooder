<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToMealsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('meals', function(Blueprint $table)
		{
            $table->integer('category_id',false,true);
            $table->index('category_id','category_id');
            $table->foreign('category_id','category_meal')
                  ->references('id')->on('meal_categories')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('meals', function(Blueprint $table)
		{
            $table->dropForeign('category_meal');
            $table->dropIndex('category_id');
            $table->dropColumn('category_id');
		});
	}

}
