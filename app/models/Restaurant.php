<?php

/**
 * Class Restaurant
 */
class Restaurant extends \Eloquent
{
    const ECOSUSHI_RESTAURANT = 'ecosushi';
    const RIKSHA_RESTAURANT = 'riksha';
    const PIZZAODUA_RESTAURANT = 'pizzaodua';
    const STARPIZZA_RESTAURANT = 'starpizza';


    protected $fillable = array('title','url', 'alias');

    /**
     * @var array
     */
    public static $rules = array(
        'default' => array(
            'title' => 'required',
            'alias' => 'required|unique',
            'url' => 'required',
        ),
    );


    /**
     * Get the format for database stored dates.
     *
     * @return string
     */
    protected function getDateFormat()
    {
        return 'U';
    }

    /**
     * @param $value
     *
     * @return int
     */
    public function getIdAttribute($value)
    {
        return intval($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany('MealCategory');
    }
}