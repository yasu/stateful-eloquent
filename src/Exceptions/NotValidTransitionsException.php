<?php

namespace Acacha\Stateful\Exceptions;

/**
 * Class NotValidTransitionsException.
 * 
 * @package Acacha\Stateful\Exceptions
 */
class NotValidTransitionsException extends \LogicException
{
    /**
     * NotValidTransitionsException constructor.
     *
     * @param string $message
     */
    public function __construct($message = 'No transitions defined for stateful object')
    {
        parent::__construct($message);
    }
}