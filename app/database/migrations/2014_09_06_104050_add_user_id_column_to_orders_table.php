<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AddUserIdColumnToOrdersTable
 */
class AddUserIdColumnToOrdersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('orders',function(Blueprint $table){
            $table->unsignedInteger('user_id');
            $table->index('user_id');
            $table->foreign('user_id','user_order_owner')->references('id')->on('users');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
