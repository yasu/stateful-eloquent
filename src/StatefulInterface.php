<?php

namespace Acacha\Stateful;

/**
 * Interface StatefulInterface
 */
interface StatefulInterface
{
    public function getInitialState();

    public function setInitialState();

    public function getStateColumn();
}