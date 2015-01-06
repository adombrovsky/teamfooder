<?php

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		 $this->call('UsersTableSeeder');
		 $this->call('MealCategoriesTableSeeder');
		 $this->call('MealsTableSeeder');
		 $this->call('OrdersTableSeeder');
		 $this->call('UserOrdersTableSeeder');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}

}
