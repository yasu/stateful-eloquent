<?php

namespace Acacha\Stateful\Tests\Models;

use Acacha\Stateful\Traits\StatefulTrait;
use Acacha\Stateful\Contracts\Stateful;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model implements Stateful
{
    use StatefulTrait;

    /**
     * Transaction States
     *
     * @var array
     */
    protected $states = [
        'draft' => ['inital' => true],
        'processing',
        'errored',
        'active',
        'closed' => ['final' => true]
    ];

    /**
     * Transaction State Transitions
     *
     * @var array
     */
    protected $transitions = [
        'process' => [
            'from' => ['draft', 'errored'],
            'to' => 'processing'
        ],
        'activate' => [
            'from' => 'processing',
            'to' => 'active'
        ],
        'fail' => [
            'from' => 'processing',
            'to' => 'errored'
        ],
        'close' => [
            'from' => 'active',
            'to' => 'close'
        ]
    ];

}
