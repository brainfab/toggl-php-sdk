<?php

namespace Brainfab\Toggl\Support;

use Brainfab\Toggl\Adapters\AccountAdapter;
use Brainfab\Toggl\Adapters\ClientAdapter;
use Brainfab\Toggl\Adapters\GroupAdapter;
use Brainfab\Toggl\Adapters\ProjectAdapter;
use Brainfab\Toggl\Adapters\ProjectUserAdapter;
use Brainfab\Toggl\Adapters\ReportAdapter;
use Brainfab\Toggl\Adapters\TagAdapter;
use Brainfab\Toggl\Adapters\TaskAdapter;
use Brainfab\Toggl\Adapters\TimeEntryAdapter;
use Brainfab\Toggl\Adapters\WorkspaceAdapter;
use Brainfab\Toggl\Managers\AccountManager;
use Brainfab\Toggl\Managers\ClientManager;
use Brainfab\Toggl\Managers\GroupManager;
use Brainfab\Toggl\Managers\ProjectManager;
use Brainfab\Toggl\Managers\ProjectUserManager;
use Brainfab\Toggl\Managers\ReportManager;
use Brainfab\Toggl\Managers\TagManager;
use Brainfab\Toggl\Managers\TimeEntryManager;
use Brainfab\Toggl\Managers\WorkspaceManager;

/**
 * Class Container.
 */
class Container
{
    /**
     * @var Collection
     */
    protected $services;

    /**
     * @var Collection
     */
    protected $cachedServices;

    /**
     * @var Collection
     */
    protected $params;

    /**
     * Container constructor.
     *
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->services = new Collection();
        $this->cachedServices = new Collection();
        $this->params = new Collection($params);

        $this->boot();
    }

    /**
     * Boot container.
     */
    protected function boot()
    {
        $this->registerManagers();
        $this->registerAdapters();
    }

    /**
     * Register managers.
     */
    protected function registerManagers()
    {
        $this->services['managers.clients'] = function (Container $container) {
            return new ClientManager(
                $container->getParameter('api_token'),
                $container->get('adapters.client'),
                $container->get('adapters.project')
            );
        };

        $this->services['managers.group'] = function (Container $container) {
            return new GroupManager(
                $container->getParameter('api_token'),
                $container->get('adapters.group')
            );
        };

        $this->services['managers.projects'] = function (Container $container) {
            return new ProjectManager(
                $container->getParameter('api_token'),
                $container->get('adapters.project'),
                $container->get('adapters.project_user'),
                $container->get('adapters.task')
            );
        };

        $this->services['managers.reports'] = function (Container $container) {
            return new ReportManager(
                $container->getParameter('api_token'),
                $container->get('adapters.report')
            );
        };

        $this->services['managers.time_entries'] = function (Container $container) {
            return new TimeEntryManager(
                $container->getParameter('api_token'),
                $container->get('adapters.time_entry')
            );
        };

        $this->services['managers.account'] = function (Container $container) {
            return new AccountManager(
                $container->getParameter('api_token'),
                $container->get('adapters.account')
            );
        };

        $this->services['managers.project_users'] = function (Container $container) {
            return new ProjectUserManager(
                $container->getParameter('api_token'),
                $container->get('adapters.project_user')
            );
        };

        $this->services['managers.tags'] = function (Container $container) {
            return new TagManager(
                $container->getParameter('api_token'),
                $container->get('adapters.tag')
            );
        };

        $this->services['managers.tasks'] = function (Container $container) {
            return new TagManager(
                $container->getParameter('api_token'),
                $container->get('adapters.task')
            );
        };

        $this->services['managers.workspaces'] = function (Container $container) {
            return new WorkspaceManager(
                $container->getParameter('api_token'),
                $container->get('adapters.workspace'),
                $container->get('adapters.account'),
                $container->get('adapters.group'),
                $container->get('adapters.client'),
                $container->get('adapters.project'),
                $container->get('adapters.task'),
                $container->get('adapters.tag')
            );
        };
    }

    /**
     * Register adapters.
     */
    protected function registerAdapters()
    {
        $this->services['adapters.client'] = function () {
            return new ClientAdapter();
        };

        $this->services['adapters.group'] = function () {
            return new GroupAdapter();
        };

        $this->services['adapters.project'] = function () {
            return new ProjectAdapter();
        };

        $this->services['adapters.project_user'] = function () {
            return new ProjectUserAdapter();
        };

        $this->services['adapters.time_entry'] = function () {
            return new TimeEntryAdapter();
        };

        $this->services['adapters.report'] = function () {
            return new ReportAdapter();
        };

        $this->services['adapters.task'] = function () {
            return new TaskAdapter();
        };

        $this->services['adapters.tag'] = function () {
            return new TagAdapter();
        };

        $this->services['adapters.workspace'] = function () {
            return new WorkspaceAdapter();
        };

        $this->services['adapters.account'] = function (Container $container) {
            return new AccountAdapter(
                $container->get('adapters.project'),
                $container->get('adapters.tag'),
                $container->get('adapters.task'),
                $container->get('adapters.workspace'),
                $container->get('adapters.client')
            );
        };
    }

    /**
     * @param string $serviceName
     *
     * @return mixed
     */
    public function has($serviceName)
    {
        return $this->services->has($serviceName);
    }

    /**
     * @param string $serviceName
     *
     * @return mixed
     */
    public function get($serviceName)
    {
        if (!$this->services->has($serviceName)) {
            throw new \RuntimeException(sprintf('Service "%s" not exists', $serviceName));
        }

        if (!$this->cachedServices->has($serviceName)) {
            $service = $this->services->get($serviceName);
            $this->cachedServices->offsetSet($serviceName, $service($this));
        }

        return $this->cachedServices->get($serviceName);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function hasParameter($name)
    {
        return $this->params->has($name);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getParameter($name)
    {
        if (!$this->params->has($name)) {
            throw new \RuntimeException(sprintf('Parameter "%s" not exists', $name));
        }

        return $this->params->get($name);
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function setParameter($name, $value)
    {
        if (!$this->params->has($name)) {
            throw new \RuntimeException(sprintf('Parameter "%s" not exists', $name));
        }

        $this->params->set($name, $value);
    }
}
