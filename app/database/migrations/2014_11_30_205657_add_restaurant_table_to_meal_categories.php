<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRestaurantTableToMealCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('meal_categories', function(Blueprint $table)
		{
            $table->integer('restaurant_id',false,true);
            $table->index('restaurant_id','restaurant_id');
            $table->foreign('restaurant_id','restaurant_category')
                  ->references('id')->on('restaurants')
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
		Schema::table('meal_categories', function(Blueprint $table)
		{
            $table->dropForeign('restaurant_category');
            $table->dropIndex('restaurant_id');
            $table->dropColumn('restaurant_id');
		});
	}

}
