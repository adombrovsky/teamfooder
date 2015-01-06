<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

/**
 * Class MealCategoriesTableSeeder
 */
class MealCategoriesTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        DB::table('meal_categories')->truncate();

        foreach(range(1, 10) as $index)
		{
			MealCategory::create([
                'title'=>$faker->company,
                'url'=>$faker->url,
			]);
		}
	}

}
