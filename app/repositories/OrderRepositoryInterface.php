<?php

/**
 * Class OrderRepositoryInterface
 */
interface OrderRepositoryInterface
{
    const RETURN_SUCCESS_STATUS = 'success';

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
     * @param $id
     * @param $data
     *
     * @return mixed
     */public function update($id, $data);

    /**
     * @param $id
     *
     * @return mixed
     */public function destroy($id);

    /**
     * @param $data
     *
     * @return mixed
     */public function validate($data);

    /**
     * @return mixed
     */
    public function instance();

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getUsersByOrder($id);

    /**
     * @param $status
     *
     * @return mixed
     */
    public function setOrderStatus($status);
}