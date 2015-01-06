<?php

/**
 * Class PermissionException
 */
class PermissionException extends Exception {

    /**
     * @param null $message
     * @param int  $code
     */
    public function __construct($message = null, $code = 403)
    {
        parent::__construct($message ?: 'Action not allowed', $code);
    }

}

/**
 * Class ValidationException
 */
class ValidationException extends Exception {

    protected $messages;

    /**
     * We are adjusting this constructor to receive an instance
     * of the validator as opposed to a string to save us some typing
     *
     * @param \Illuminate\Validation\Validator $validator failed validator object
     */
    public function __construct(Illuminate\Validation\Validator $validator)
    {
        $this->messages = $validator->messages();
        parent::__construct(json_encode($this->messages), 400);
    }

    public function getMessages()
    {
        return $this->messages;
    }

}
/**
 * Class ValidationException
 */
class ValidationScenarioException extends Exception {

    /**
     * @param null $message
     * @param int  $code
     */
    public function __construct($message = null, $code = 403)
    {
        parent::__construct($message ?: 'Scenario not found', $code);
    }

}

/**
 * Class NotFoundException
 */
class NotFoundException extends Exception {

    /**
     * @param null $message
     * @param int  $code
     */
    public function __construct($message = null, $code = 404)
    {
        parent::__construct($message ?: 'Resource Not Found', $code);
    }

}