<?php

/**
 * Class RestaurantsTableSeeder
 */
class RestaurantsTableSeeder extends Seeder {

	public function run()
	{
        DB::table('restaurants')->delete();
        $restaurants = array(
            array('title'=>'Riksha','url'=>'http://riksha.com.ua', 'alias'=>'riksha'),
            array('title'=>'StarPizza','url'=>'http://starpizzacafe.com', 'alias'=>'starpizza'),
        );
        foreach($restaurants as $restaurant)
		{
			Restaurant::create($restaurant);
		}
	}

}
