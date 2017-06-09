<?php

namespace Brainfab\Toggl\Entities;

use Carbon\Carbon;

class ProjectUser extends Entity
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $pid;

    /**
     * @var integer
     */
    public $uid;

    /**
     * @var integer
     */
    public $wid;

    /**
     * @var bool
     */
    public $manager;

    /**
     * @var float
     */
    public $rate;

    /**
     * @var Carbon
     */
    public $at;
}
