<?php

/**
 * Class ContactRepositoryInterface
 */
interface ContactRepositoryInterface
{
    /**
     * @return mixed
     */
    public function findAll();

    /**
     * @param null $limit
     *
     * @return mixed
     */
    public function paginate($limit = null);
}