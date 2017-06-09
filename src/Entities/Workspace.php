<?php

namespace Brainfab\Toggl\Entities;

use Carbon\Carbon;

class Workspace extends Entity
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
     * @var bool
     */
    public $premium;

    /**
     * @var bool
     */
    public $admin;

    /**
     * @var float
     */
    public $defaultHourlyRate;

    /**
     * @var string
     */
    public $defaultCurrency;

    /**
     * @var bool
     */
    public $onlyAdminsMayCreateProjects;

    /**
     * @var bool
     */
    public $onlyAdminsSeeBillableRates;

    /**
     * @var int
     */
    public $rounding;

    /**
     * @var int
     */
    public $roundingMinutes;

    /**
     * @var Carbon
     */
    public $at;

    /**
     * @var string
     */
    public $logoUrl;
}
