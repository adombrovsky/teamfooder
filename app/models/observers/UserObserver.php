<?php

/**
 * Class UserObserver
 */
class UserObserver
{
    /**
     * @param $model
     */
    public function creating($model)
    {
        $model->password = Hash::make($model->password);
    }
}