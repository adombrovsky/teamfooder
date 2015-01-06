<?php

/**
 * Class Order
 */
class Order extends \Eloquent
{
    const IN_PROGRESS_STATUS = 0;
    const COMPLETED_STATUS = 1;
    const EXPIRED_STATUS = 2;
    const DENY_STATUS = 3;

    private static $statuses = array(
        self::IN_PROGRESS_STATUS=>'In progress',
        self::COMPLETED_STATUS=>'Completed',
        self::EXPIRED_STATUS=>'Expired',
        self::DENY_STATUS=>'Denied',

    );

    protected $fillable = array('title','description','sum','date', 'restaurant_id', 'user_id','status');

    /**
     * @var array
     */
    public static $rules = array(
        'default' => array(
            'title' => 'required',
            'restaurant_id' => 'required|exists:restaurants,id',
            'date' => 'required|date',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userOrders()
    {
        return $this->hasMany('UserOrder');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function restaurant()
    {
        return $this->belongsTo('Restaurant');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('User', 'user_orders')->groupBy('order_id','user_id');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function owner()
    {
        return $this->belongsTo('User','user_id');
    }

    /**
     * @param null $key
     *
     * @return mixed
     */
    public function getStatusName($key = NULL)
    {
        if (!$key)
        {
            $key = $this->status;
        }

        return self::$statuses[$key];
    }

    /**
     * @param $emails
     */
    public function newOrderNotifier($emails)
    {
        foreach ($emails as $email)
        {
            $name = $email['title'];
            $emailAddress = $email['email'];
            $order = $this;

            Mail::send('emails.order.created', array('order'=>$this), function(Illuminate\Mail\Message $message) use ($email, $name, $emailAddress, $order)
            {
                $message->to($emailAddress, $name);
                $message->subject('['.Config::get('app.name').'] You have been invited by '.$order->owner->name.' to the new food request.');
            });
        }
    }
}