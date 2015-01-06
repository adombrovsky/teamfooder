<?php

/**
 * Class RestaurantRepositoryInterface
 */
interface RestaurantRepositoryInterface
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function findById($id);

    /**
     * @return mixed
     */
    public function findAll();
}