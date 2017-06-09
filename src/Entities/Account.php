<?php

namespace Brainfab\Toggl\Entities;

use Carbon\Carbon;

class Account extends Entity
{
    /**
     * @var int
     */
    public $since;

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $apiToken;

    /**
     * @var int
     */
    public $defaultWid;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $fullname;

    /**
     * @var string
     */
    public $jqueryTimeofdayFormat;

    /**
     * @var string
     */
    public $jqueryDateFormat;

    /**
     * @var string
     */
    public $timeofdayFormat;

    /**
     * @var string
     */
    public $dateFormat;

    /**
     * @var bool
     */
    public $storeStartAndStopTime;

    /**
     * @var int
     */
    public $beginningOfWeek;

    /**
     * @var string
     */
    public $language;

    /**
     * @var string
     */
    public $durationFormat;

    /**
     * @var string
     */
    public $imageUrl;

    /**
     * @var Carbon
     */
    public $at;

    /**
     * @var Carbon
     */
    public $createdAt;

    /**
     * @var string
     */
    public $timezone;

    /**
     * @var int
     */
    public $retention;

    /**
     * @var array
     */
    public $newBlogPost;

    /**
     * @var Project[]
     */
    public $projects;

    /**
     * @var Tag[]
     */
    public $tags;

    /**
     * @var Task[]
     */
    public $tasks;

    /**
     * @var Workspace[]
     */
    public $workspaces;

    /**
     * @var Client[]
     */
    public $clients;

    /**
     * @var bool
     */
    public $sidebarPiechart;

    /**
     * @var bool
     */
    public $renderTimeline;

    /**
     * @var bool
     */
    public $timelineExperiment;

    /**
     * @var bool
     */
    public $shouldUpgrade;

    /**
     * @var array
     */
    public $invitation;
}
