<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

/**
 * Class MealsTableSeeder
 */
class MealsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        DB::table('meals')->truncate();
        $categories = MealCategory::lists('id');
        sort($categories);
        foreach(range(1, 10) as $index)
		{
			Meal::create([
                'title'=>$faker->company,
                'category_id'=>mt_rand($categories[0],$categories[count($categories)-1]),
                'price'=>$faker->randomFloat()
			]);
		}
	}

}
