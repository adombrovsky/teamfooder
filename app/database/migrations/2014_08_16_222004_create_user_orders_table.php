<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateUserOrdersTable
 */
class CreateUserOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id',false, true);
			$table->integer('meal_id',false, true);
			$table->integer('order_id',false, true);
			$table->integer('count');
            $table->integer('created_at');
            $table->integer('updated_at');

            $table->index('user_id');
            $table->index('meal_id');
            $table->index('order_id');

            $table->foreign('user_id')
              ->references('id')->on('users')
              ->onUpdate('cascade')
              ->onDelete('cascade');
            $table->foreign('meal_id')
              ->references('id')->on('meals')
              ->onUpdate('cascade')
              ->onDelete('cascade');

            $table->foreign('order_id')
              ->references('id')->on('orders')
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
		Schema::drop('user_orders');
	}

}
