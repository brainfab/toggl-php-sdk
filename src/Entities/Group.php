<?php

namespace Brainfab\Toggl\Entities;

use Carbon\Carbon;

class Group extends Entity
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $wid;

    /**
     * @var string
     */
    public $name;

    /**
     * @var Carbon
     */
    public $at;
}
