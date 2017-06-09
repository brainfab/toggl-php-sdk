<?php

namespace Brainfab\Toggl\Entities;

use Carbon\Carbon;

class Client extends Entity
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
     * @var string
     */
    public $notes;

    /**
     * @var int
     */
    public $hrate;

    /**
     * @var string
     */
    public $cur;

    /**
     * @var Carbon
     */
    public $at;
}
