<?php

namespace Brainfab\Toggl;

use Brainfab\Toggl\Entities\ProjectUser;
use Brainfab\Toggl\Managers\AccountManager;
use Brainfab\Toggl\Managers\ClientManager;
use Brainfab\Toggl\Managers\GroupManager;
use Brainfab\Toggl\Managers\ProjectManager;
use Brainfab\Toggl\Managers\ProjectUserManager;
use Brainfab\Toggl\Managers\ReportManager;
use Brainfab\Toggl\Managers\TagManager;
use Brainfab\Toggl\Managers\TaskManager;
use Brainfab\Toggl\Managers\TimeEntryManager;
use Brainfab\Toggl\Managers\WorkspaceManager;
use Brainfab\Toggl\Support\Container;

/**
 * Class Toggl.
 */
class Toggl
{
    /**
     * @var string Default dates format.
     */
    const ISO8601 = 'Y-m-d\TH:i:sP';

    /**
     * @var Container
     */
    protected $container;

    /**
     * Toggl constructor.
     *
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->container = new Container([
            'api_token' => $apiKey
        ]);
    }

    /**
     * @return AccountManager
     */
    public function account()
    {
        return $this->container->get('managers.account');
    }

    /**
     * @return TimeEntryManager
     */
    public function timeEntries()
    {
        return $this->container->get('managers.time_entries');
    }

    /**
     * @return ClientManager
     */
    public function clients()
    {
        return $this->container->get('managers.clients');
    }

    /**
     * @return ProjectManager
     */
    public function projects()
    {
        return $this->container->get('managers.projects');
    }

    /**
     * @return WorkspaceManager
     */
    public function workspaces()
    {
        return $this->container->get('managers.workspaces');
    }

    /**
     * @return ProjectUserManager
     */
    public function projectUsers()
    {
        return $this->container->get('managers.project_users');
    }

    /**
     * @return TagManager
     */
    public function tags()
    {
        return $this->container->get('managers.tags');
    }

    /**
     * @return TaskManager
     */
    public function tasks()
    {
        return $this->container->get('managers.tasks');
    }

    /**
     * @return GroupManager
     */
    public function groups()
    {
        return $this->container->get('managers.groups');
    }

    /**
     * @return ReportManager
     */
    public function reports()
    {
        return $this->container->get('managers.reports');
    }
}
