<?php

/**
 * Class Meal
 */
class Meal extends \Eloquent {
	protected $fillable = array(
        'title',
        'price',
        'category_id',
        'description',
        'image',
        'url'
    );

    /**
     * @var array
     */
    public static $rules = array(
        'default' => array(
            'title' => 'required',
            'category_id' => 'required',
            'price' =>'required|numeric'
        ),
    );

    protected $appends = array(
        'imageUrl',
        'mealUrl'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('MealCategory','category_id');
    }

    /**
     * @return string
     */
    public function getImageUrlAttribute()
    {
        $fileName = $this->image ? $this->image : 'no-image.png';
        $filePath = public_path('images/'.$fileName);
        return file_exists($filePath) ? '/images/'.$fileName : '';
    }

    /**
     * @return string
     */
    public function getMealUrlAttribute()
    {
        return boolval($this->url) ? $this->url : $this->category->url;
    }
}