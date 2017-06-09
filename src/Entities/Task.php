<?php

namespace Brainfab\Toggl\Entities;

use Carbon\Carbon;

class Task extends Entity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $pid;

    /**
     * @var int
     */
    public $wid;

    /**
     * @var int
     */
    public $uid;

    /**
     * @var int
     */
    public $estimatedSeconds;

    /**
     * @var bool
     */
    public $active;

    /**
     * @var int
     */
    public $trackedSeconds;

    /**
     * @var Carbon
     */
    public $at;
}
