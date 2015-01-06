<?php

use Illuminate\Auth\UserInterface;
use \Illuminate\Auth\Reminders\RemindableInterface;

/**
 * Class User
 */
class User extends Eloquent implements UserInterface, RemindableInterface
{

    const DEFAULT_SCENARIO = 'default';
    const CREATE_SCENARIO = 'create';

	protected $fillable = array('name','email');
    protected $guarded = array('id', 'password');
    protected $hidden = array('password','remember_token');

    /**
     * @var array
     */
    public static $rules = array(
        self::DEFAULT_SCENARIO => array(
            'password' => 'required',
            'email' =>'required|email|unique:users'
        ),
        self::CREATE_SCENARIO => array(
            'email' =>'required|email|unique:users',
            'password' => 'required',
            'name' => 'required',
            're-password' => 'required|same:password',
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
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed|string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * @param string $value
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail ()
    {
        return $this->email;
    }
}