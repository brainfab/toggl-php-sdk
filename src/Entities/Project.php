<?php

namespace Brainfab\Toggl\Entities;

use Carbon\Carbon;

class Project extends Entity
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var integer
     */
    public $wid;

    /**
     * @var integer
     */
    public $cid;

    /**
     * @var boolean
     */
    public $active;

    /**
     * @var boolean
     */
    public $isPrivate;

    /**
     * @var boolean
     */
    public $template;

    /**
     * @var integer
     */
    public $templateId;

    /**
     * @var boolean
     */
    public $billable;

    /**
     * @var boolean
     */
    public $autoEstimates;

    /**
     * @var integer
     */
    public $estimatedHours;

    /**
     * @var Carbon
     */
    public $at;

    /**
     * @var integer
     */
    public $color;

    /**
     * @var float
     */
    public $rate;
}
