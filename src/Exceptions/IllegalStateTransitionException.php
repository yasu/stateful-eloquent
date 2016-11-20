<?php

namespace Acacha\Stateful\Exceptions;

use Illuminate\Support\MessageBag;

/**
 * Class IllegalStateTransitionException.
 * 
 * @package Acacha\Stateful\Exceptions
 */
class IllegalStateTransitionException extends \LogicException
{
    /**
     * Messages related to this exception.
     * 
     * @var MessageBag
     */
    protected $messages;

    /**
     * IllegalStateTransitionException constructor.
     * 
     * @param $messages
     */
    public function __construct(MessageBag $messages)
    {
        $this->messages = $messages;
    }

    /**
     * Get messages. 
     * 
     * @return MessageBag
     */
    public function messages()
    {
        return $this->messages;
    }

    
}