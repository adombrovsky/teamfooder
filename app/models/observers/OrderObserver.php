<?php

/**
 * Class OrderObserver
 */
class OrderObserver
{

    /**
     * @param $model
     */
    public function saving($model)
    {
        $model->date = strtotime($model->date);
    }

}