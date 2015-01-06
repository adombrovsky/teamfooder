<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

/**
 * Class UserOrdersTableSeeder
 */
class UserOrdersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        DB::table('user_orders')->truncate();


        foreach(range(1, 20) as $index)
		{
			UserOrder::create([
                'user_id'=>$faker->numberBetween(1,10),
                'order_id'=>$faker->numberBetween(1,10),
                'meal_id' =>$faker->numberBetween(1,10),
                'count'=>$faker->numberBetween(1,10)
			]);
		}
	}

}
