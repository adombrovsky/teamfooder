<?php

/**
 * Class MealCategory
 */
class MealCategory extends \Eloquent {
	protected $fillable = array('title','url', 'restaurant_id');

    /**
     * @var array
     */
    public static $rules = array(
        'default' => array(
            'title' => 'required',
            'url' => 'required',
            'restaurant_id' => 'required',
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
    public function meals()
    {
        return $this->hasMany('Meal','category_id');
    }
}