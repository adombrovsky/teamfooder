<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        DB::table('users')->truncate();
		foreach(range(1, 10) as $index)
		{
			User::create([
                'email'=>$faker->email,
                'name'=>$faker->name
            ]);
		}
	}

}
