<?php

namespace Brainfab\Toggl\Managers;

use Brainfab\Toggl\Adapters\AccountAdapter;
use Brainfab\Toggl\Adapters\ClientAdapter;
use Brainfab\Toggl\Adapters\GroupAdapter;
use Brainfab\Toggl\Adapters\ProjectAdapter;
use Brainfab\Toggl\Adapters\TagAdapter;
use Brainfab\Toggl\Adapters\TaskAdapter;
use Brainfab\Toggl\Adapters\WorkspaceAdapter;
use Brainfab\Toggl\Entities\Account;
use Brainfab\Toggl\Entities\Client;
use Brainfab\Toggl\Entities\Group;
use Brainfab\Toggl\Entities\Project;
use Brainfab\Toggl\Entities\Tag;
use Brainfab\Toggl\Entities\Task;
use Brainfab\Toggl\Entities\Workspace;
use Brainfab\Toggl\Support\Arr;
use Brainfab\Toggl\Support\Collection;
use GuzzleHttp\RequestOptions;

/**
 * Class WorkspaceManager.
 */
class WorkspaceManager extends BaseManager
{
    /**
     * @var WorkspaceAdapter
     */
    protected $workspaceAdapter;

    /**
     * @var AccountAdapter
     */
    protected $accountAdapter;

    /**
     * @var GroupAdapter
     */
    protected $groupAdapter;

    /**
     * @var ClientAdapter
     */
    protected $clientAdapter;

    /**
     * @var ProjectAdapter
     */
    protected $projectAdapter;

    /**
     * @var TaskAdapter
     */
    protected $taskAdapter;

    /**
     * @var TagAdapter
     */
    protected $tagAdapter;

    /**
     * WorkspaceManager constructor.
     *
     * @param string           $apiKey
     * @param WorkspaceAdapter $workspaceAdapter
     * @param AccountAdapter   $accountAdapter
     * @param GroupAdapter     $groupAdapter
     * @param ClientAdapter    $clientAdapter
     * @param ProjectAdapter   $projectAdapter
     * @param TaskAdapter      $taskAdapter
     * @param TagAdapter       $tagAdapter
     */
    public function __construct(
        $apiKey,
        WorkspaceAdapter $workspaceAdapter,
        AccountAdapter $accountAdapter,
        GroupAdapter $groupAdapter,
        ClientAdapter $clientAdapter,
        ProjectAdapter $projectAdapter,
        TaskAdapter $taskAdapter,
        TagAdapter $tagAdapter
    ) {
        parent::__construct($apiKey);

        $this->workspaceAdapter = $workspaceAdapter;
        $this->accountAdapter = $accountAdapter;
        $this->groupAdapter = $groupAdapter;
        $this->clientAdapter = $clientAdapter;
        $this->projectAdapter = $projectAdapter;
        $this->taskAdapter = $taskAdapter;
        $this->tagAdapter = $tagAdapter;
    }

    /**
     * @return Collection|Workspace[]
     */
    public function all()
    {
        $response = $this->client->get($this->url('workspaces'));
        $data = $this->decodeResponse($response);

        $result = new Collection();
        foreach ($data as $itemData) {
            $result[] = $this->workspaceAdapter->transform($itemData);
        }

        return $result;
    }

    /**
     * @return Workspace
     */
    public function find($id)
    {
        $response = $this->client->get($this->url('workspaces/{id}', ['id' => $id]));
        $data = Arr::get($this->decodeResponse($response), 'data');

        return $this->workspaceAdapter->transform($data);
    }

    /**
     * @param Workspace $workspace
     */
    public function update(Workspace $workspace)
    {
        $body = $this->encodeRequestData([
            'workspace' => $this->workspaceAdapter->serialize($workspace)
        ]);

        $response = $this->client->request(
            'PUT',
            $this->url('workspaces/{id}', ['id' => $workspace->id]),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->workspaceAdapter->transform(Arr::get($data, 'data'), $workspace);
    }

    /**
     * @param int|Workspace $workspace
     *
     * @return Account[]|Collection
     */
    public function users($workspace)
    {
        $id = $workspace instanceof Workspace ? $workspace->id : $workspace;

        $response = $this->client->get($this->url('workspaces/{id}/users', ['id' => $id]));
        $data = $this->decodeResponse($response);

        $result = new Collection();
        foreach ($data as $itemData) {
            $result[] = $this->accountAdapter->transform(['data' => $itemData]);
        }

        return $result;
    }

    /**
     * @param int|Workspace $workspace
     *
     * @return Client[]|Collection
     */
    public function clients($workspace)
    {
        $id = $workspace instanceof Workspace ? $workspace->id : $workspace;

        $response = $this->client->get($this->url('workspaces/{id}/clients', ['id' => $id]));
        $data = $this->decodeResponse($response);

        $result = new Collection();
        foreach ($data as $itemData) {
            $result[] = $this->clientAdapter->transform($itemData);
        }

        return $result;
    }

    /**
     * @param int|Workspace $workspace
     *
     * @return Group[]|Collection
     */
    public function groups($workspace)
    {
        $id = $workspace instanceof Workspace ? $workspace->id : $workspace;

        $response = $this->client->get($this->url('workspaces/{id}/groups', ['id' => $id]));
        $data = $this->decodeResponse($response);

        $result = new Collection();
        foreach ($data as $itemData) {
            $result[] = $this->groupAdapter->transform($itemData);
        }

        return $result;
    }

    /**
     * @param int|Workspace $workspace
     *
     * @return Project[]|Collection
     */
    public function projects($workspace)
    {
        $id = $workspace instanceof Workspace ? $workspace->id : $workspace;

        $response = $this->client->get($this->url('workspaces/{id}/projects', ['id' => $id]));
        $data = $this->decodeResponse($response);

        $result = new Collection();
        foreach ($data as $itemData) {
            $result[] = $this->projectAdapter->transform($itemData);
        }

        return $result;
    }

    /**
     * @param int|Workspace $workspace
     *
     * @return Task[]|Collection
     */
    public function tasks($workspace)
    {
        $id = $workspace instanceof Workspace ? $workspace->id : $workspace;

        $response = $this->client->get($this->url('workspaces/{id}/tasks', ['id' => $id]));
        $data = $this->decodeResponse($response);

        $result = new Collection();
        foreach ($data as $itemData) {
            $result[] = $this->taskAdapter->transform($itemData);
        }

        return $result;
    }

    /**
     * @param int|Workspace $workspace
     *
     * @return Tag[]|Collection
     */
    public function tags($workspace)
    {
        $id = $workspace instanceof Workspace ? $workspace->id : $workspace;

        $response = $this->client->get($this->url('workspaces/{id}/tags', ['id' => $id]));
        $data = $this->decodeResponse($response);

        $result = new Collection();
        foreach ($data as $itemData) {
            $result[] = $this->tagAdapter->transform($itemData);
        }

        return $result;
    }
}
