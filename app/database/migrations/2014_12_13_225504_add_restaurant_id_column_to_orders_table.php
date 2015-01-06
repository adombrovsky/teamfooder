<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRestaurantIdColumnToOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			$table->integer('restaurant_id',false, true);
			$table->index('restaurant_id');
			$table->foreign('restaurant_id','restaurant_order')
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
		Schema::table('orders', function(Blueprint $table)
		{
			$table->dropForeign('restaurant_order');
			$table->dropIndex('restaurant_id');
			$table->dropColumn('restaurant_id');
		});
	}

}
