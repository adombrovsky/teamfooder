<?php

/**
 * Class UserOrder
 */
class UserOrder extends Eloquent
{
	protected $fillable = array('user_id','meal_id','order_id','count');

    public static $rules = array(
        'default' => array(
            'user_id'   =>'required',
            'meal_id'   =>'required',
            'order_id'  =>'required',
            'count'     =>'required|integer|min:1'
        )
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meal()
    {
        return $this->belongsTo('Meal');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('Order');

    }

    /**
     * @param $value
     *
     * @return int
     */
    public function getUserIdAttribute($value)
    {
        return intval($value);
    }

    /**
     * @param $value
     *
     * @return int
     */
    public function getOrderIdAttribute($value)
    {
        return intval($value);
    }

    /**
     * @param $value
     *
     * @return int
     */
    public function getMealIdAttribute($value)
    {
        return intval($value);
    }

    /**
     * @param $orderId
     *
     * @param $status
     *
     * @return bool
     */
    public static function notifyUsersByOrderId($orderId, $status)
    {
        $users = self::where('order_id','=',$orderId)->groupBy('user_id')->get();
        $order = Order::find($orderId);
        $orderName = $order->title;
        switch ($status)
        {
            case Order::COMPLETED_STATUS:
                $emailTemplate = 'emails.order.finish';
                $subject = '['.Config::get('app.name').'] Food request "'.$orderName.'" has been finished.';
                break;
            case Order::DENY_STATUS:
                $emailTemplate = 'emails.order.deny';
                $subject = '['.Config::get('app.name').'] Food request "'.$orderName.'" has been denied.';
                break;
            default:
                return false;
        }

        foreach ($users as $user)
        {
            $email = $user->user->email;
            $name = $user->user->name;
            Mail::send($emailTemplate, array('order'=>$user->order), function(Illuminate\Mail\Message $message) use ($email, $name, $orderName, $subject)
            {
                $message->to($email, $name);
                $message->subject($subject);
            });
        }
        return true;
    }

}