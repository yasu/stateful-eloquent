<?php

namespace Acacha\Stateful\Traits;
use Acacha\Stateful\Events\Registered;
use Acacha\Stateful\Exceptions\IllegalStateTransitionException;
use Illuminate\Support\MessageBag;

/**
 * Class StatefulTrait.
 *
 * @package Acacha\Stateful
 */
trait StatefulTrait
{

    /**
     * Error messages on last transition.
     *
     * @var MessageBag
     */
    protected $errorMessages;

    /**
     * Overload methods.
     * 
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (array_key_exists($method, $this->transitions)) {
            return $this->performTransition($method);
        } elseif (array_key_exists($method, $this->states) || in_array($method, $this->states)) {
            return $this->isState($method);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Determine if the state of the model is the given state.
     * 
     * @param $state
     * @return bool
     */
    private function isState($state)
    {
        return $state === $this->{$this->getStateColumn()};
    }

    /**
     * Perform a state transition.
     * 
     * @param $transition
     * @return mixed
     * @throws IllegalStateTransitionException
     */
    private function performTransition($transition)
    {
        $to = $this->transitions[$transition]['to'];

        if ($this->canPerformTransition($transition)) {
            $this->executeBeforeTransitionHook($transition);
            $result = $this->updateState($to);
            $this->executeAfterTransitionHook($transition);
            event(new Registered($this,$this->{$this->getStateColumn()},$to));
            return $result;
        }
        throw new IllegalStateTransitionException($this->errorMessages);
        
    }

    /**
     * Update state.
     *
     * @param $state
     * @return mixed
     */
    protected function updateState($state) {
        return $this->update([$this->getStateColumn() => $state]);
    }

    /**
     * Execute if exists hook before transition.
     *
     * @param string $transition
     */
    protected function executeBeforeTransitionHook($transition)
    {
        $this->executeHook($transition,'before');
    }

    /**
     * Execute if exists hook after transition.
     *
     * @param string $transition
     */
    protected function executeAfterTransitionHook($transition)
    {
        $this->executeHook($transition,'after');
    }

    /**
     * Execute hook.
     *
     * @param string $transition
     * @param string $hook
     */
    protected function executeHook($transition,$hook)
    {
        if (method_exists($this, $method = $hook . studly_case($transition))) {
            $this->{$method};
        }
    }

    /**
     * Determine if we can perform the state transition.
     *
     * @param  string $transition
     * @return boolean
     */
    private function canPerformTransition($transition)
    {
        $from = $this->transitions[$transition]['from'];
        $currentState = $this->{$this->getStateColumn()};


        if(method_exists($this, $method = 'validate' . studly_case($transition) ))
        {
            if ($this->{$method} === false ) return false;
        }

        return $this->checkTransitionBetweenStatesIsAllowed($from, $currentState);
    }

    /**
     * @param $from
     * @param $currentState
     * @return bool
     */
    private function checkTransitionBetweenStatesIsAllowed($from, $currentState)
    {
        $result = is_array($from) ? in_array($currentState, $from) : $currentState === $from;
        if ($result === false) {
            $this->errorMessages->add(
                'transitionNotDefined',
                'There is no transition defined between states ' . $from . ' and ' . $currentState);
        }
        return $result;
    }


    /**
     * Set the initial state.
     *
     * @return void
     */
    public function setInitialState()
    {
        $this->setAttribute($this->getStateColumn(), $this->getInitialState());
    }

    /**
     * Get the inital state.
     * 
     * @return bool|int|string
     */
    public function getInitialState()
    {
        foreach ($this->states as $state => $value) {
            if ($value['inital']) {
               return $state;
            }
        }

        return false;
    }

    /**
     * Get the state attribute name.
     * @return string
     */
    public function getStateColumn()
    {
        return defined('static::STATE') ? static::STATE : 'state';
    }

}