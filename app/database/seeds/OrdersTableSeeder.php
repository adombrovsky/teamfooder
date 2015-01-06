<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

/**
 * Class OrdersTableSeeder
 */
class OrdersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        DB::table('orders')->truncate();

        foreach(range(1, 10) as $index)
		{
			Order::create([
                'date'=>$faker->dateTimeBetween(time()-10000,time())->getTimestamp(),
                'title'=>$faker->realText(30),
                'url'=>$faker->url,
                'description'=>$faker->realText(100),
                'sum' =>$faker->randomNumber()
			]);
		}
	}

}
