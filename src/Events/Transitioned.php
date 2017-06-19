<?php

namespace Yasu\Stateful\Events;

use Yasu\Stateful\Contracts\Stateful;

/**
 * Event Registered. 
 * 
 * @package Yasu\Stateful\Events
 */
class Transitioned
{

    /**
     * Previous state.
     *
     * @var
     */
    public $previousState;

    /**
     * Current state.
     *
     * @var
     */
    public $currentState;

    /**
     * The transitioned model.
     *
     * @var Stateful
     */
    public $model;

    /**
     * Registered constructor.
     *
     * @param $previousState
     * @param $currentState
     * @param Stateful $model
     */
    public function __construct(Stateful $model,$previousState, $currentState)
    {
        $this->previousState = $previousState;
        $this->currentState = $currentState;
        $this->model = $model;
    }
}
