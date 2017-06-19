<?php

namespace Yasu\Stateful\Exceptions;

/**
 * Class NotValidTransitionsException.
 * 
 * @package Yasu\Stateful\Exceptions
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