<?php

namespace Acacha\Stateful\Contracts;

/**
 * Interface Stateful
 */
interface Stateful
{
    public function getInitialState();

    public function setInitialState();

    public function getStateColumn();
}