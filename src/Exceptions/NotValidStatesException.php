<?php

namespace Acacha\Stateful\Exceptions;

/**
 * Class NotValidStatesException.
 * 
 * @package Acacha\Stateful\Exceptions
 */
class NotValidStatesException extends \LogicException
{
    /**
     * NotValidStatesException constructor.
     *
     * @param string $message
     */
    public function __construct($message = 'No states defined for stateful object')
    {
        parent::__construct($message);
    }
}