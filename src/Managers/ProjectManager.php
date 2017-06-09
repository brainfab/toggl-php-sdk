<?php

namespace Brainfab\Toggl\Managers;

use Brainfab\Toggl\Adapters\ProjectAdapter;
use Brainfab\Toggl\Adapters\ProjectUserAdapter;
use Brainfab\Toggl\Adapters\TaskAdapter;
use Brainfab\Toggl\Entities\Project;
use Brainfab\Toggl\Entities\ProjectUser;
use Brainfab\Toggl\Entities\Task;
use Brainfab\Toggl\Support\Arr;
use Brainfab\Toggl\Support\Collection;
use GuzzleHttp\RequestOptions;

/**
 * Class ProjectManager.
 */
class ProjectManager extends BaseManager
{
    /**
     * @var ProjectAdapter
     */
    protected $projectAdapter;

    /**
     * @var ProjectUserAdapter
     */
    protected $projectUserAdapter;

    /**
     * @var TaskAdapter
     */
    protected $taskAdapter;

    /**
     * ProjectManager constructor.
     *
     * @param string             $apiKey
     * @param ProjectAdapter     $projectAdapter
     * @param ProjectUserAdapter $projectUserAdapter
     * @param TaskAdapter        $taskAdapter
     */
    public function __construct(
        $apiKey,
        ProjectAdapter $projectAdapter,
        ProjectUserAdapter $projectUserAdapter,
        TaskAdapter $taskAdapter
    ) {
        parent::__construct($apiKey);

        $this->projectAdapter = $projectAdapter;
        $this->projectUserAdapter = $projectUserAdapter;
        $this->taskAdapter = $taskAdapter;
    }

    /**
     * @return Project
     */
    public function find($id)
    {
        $response = $this->client->get($this->url('projects/{id}', ['id' => $id]));
        $data = Arr::get($this->decodeResponse($response), 'data');

        return $this->projectAdapter->transform($data);
    }

    /**
     * @param Project $project
     */
    public function create(Project $project)
    {
        $body = $this->encodeRequestData([
            'project' => $this->projectAdapter->serialize($project)
        ]);

        $response = $this->client->request(
            'POST',
            $this->url('projects'),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->projectAdapter->transform(Arr::get($data, 'data'), $project);
    }

    /**
     * @param Project $project
     */
    public function update(Project $project)
    {
        $body = $this->encodeRequestData([
            'project' => $this->projectAdapter->serialize($project)
        ]);

        $response = $this->client->request(
            'PUT',
            $this->url('projects/{id}', ['id' => $project->id]),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->projectAdapter->transform(Arr::get($data, 'data'), $project);
    }

    /**
     * @param integer|Project|int[]|Project[] $project
     */
    public function destroy($project)
    {
        $projects = is_array($project) ? $project : [$project];
        $ids = array_map(function ($project) {
            return $project instanceof Project ? $project->id : $project;
        }, $projects);

        $id = implode(',', $ids);

        $this->client->request(
            'DELETE',
            $this->url('projects/{id}', ['id' => $id])
        );
    }

    /**
     * @param integer|Project $project
     *
     * @return Collection|ProjectUser[]
     */
    public function users($project)
    {
        $id = $project instanceof Project ? $project->id : $project;

        $response = $this->client->request(
            'PUT',
            $this->url('projects/{id}/project_users', ['id' => $id])
        );

        $data = $this->decodeResponse($response);

        $result = new Collection();
        foreach ($data as $item) {
            $result[] = $this->projectUserAdapter->transform($item);
        }

        return $result;
    }

    /**
     * @param integer|Project $project
     *
     * @return Collection|Task[]
     */
    public function tasks($project)
    {
        $id = $project instanceof Project ? $project->id : $project;

        $response = $this->client->request(
            'PUT',
            $this->url('projects/{id}/tasks', ['id' => $id])
        );

        $data = $this->decodeResponse($response);

        $result = new Collection();
        foreach ($data as $item) {
            $result[] = $this->taskAdapter->transform($item);
        }

        return $result;
    }
}
