<?php

namespace Brainfab\Toggl\Entities;

use Carbon\Carbon;

class TimeEntry extends Entity
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $description;

    /**
     * @var integer
     */
    public $wid;

    /**
     * @var integer
     */
    public $pid;

    /**
     * @var integer
     */
    public $tid;

    /**
     * @var boolean
     */
    public $billable;

    /**
     * @var Carbon
     */
    public $start;

    /**
     * @var Carbon
     */
    public $stop;

    /**
     * @var integer
     */
    public $duration;

    /**
     * @var string
     */
    public $createdWith;

    /**
     * @var string[]
     */
    public $tags;

    /**
     * @var boolean
     */
    public $duronly;

    /**
     * @var Carbon
     */
    public $at;
}
