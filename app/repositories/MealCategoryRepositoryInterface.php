<?php

/**
 * Class MealCategoryRepositoryInterface
 */
interface MealCategoryRepositoryInterface
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function findById($id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findByOrder($id);

    /**
     * @return mixed
     */
    public function findAll();

    /**
     * @param null $limit
     *
     * @return mixed
     */public function paginate($limit = null);

    /**
     * @param $data
     *
     * @return mixed
     */public function store($data);

    /**
     * @param $data
     *
     * @return mixed
     */public function validate($data);

    /**
     * @return mixed
     */
    public function instance();
}