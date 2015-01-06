<?php

/**
 * Class EloquentRestaurantRepository
 */
class EloquentRestaurantRepository implements RestaurantRepositoryInterface
{


    /**
     * @param $id
     *
     * @throws NotFoundException
     * @return Restaurant
     */
    public function findById ($id)
    {
        $restaurant = Restaurant::find($id);

        if (!$restaurant)
        {
            throw new NotFoundException('Restaurant not found');
        }
        return $restaurant;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll ()
    {
        $restaurants = Restaurant::all();
        $result = array();
        /**
         * we should return only restaurants with meals and categories
         */
        foreach ($restaurants as $restaurant)
        {
            if ($restaurant->categories)
            {
                foreach ($restaurant->categories as $category)
                {
                    if ($category->meals)
                    {
                        /**
                         * @var $restaurant Restaurant
                         */
                        $result[] = $restaurant->getAttributes();
                        break;
                    }
                }
            }
        }

        return $result;
    }
}