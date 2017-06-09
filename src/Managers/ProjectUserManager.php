<?php

namespace Brainfab\Toggl\Managers;

use Brainfab\Toggl\Adapters\ProjectUserAdapter;
use Brainfab\Toggl\Entities\ProjectUser;
use Brainfab\Toggl\Support\Arr;
use GuzzleHttp\RequestOptions;

/**
 * Class ProjectUserManager.
 */
class ProjectUserManager extends BaseManager
{
    /**
     * @var ProjectUserAdapter
     */
    protected $projectUserAdapter;

    /**
     * ProjectUserManager constructor.
     *
     * @param string             $apiKey
     * @param ProjectUserAdapter $projectUserAdapter
     */
    public function __construct(
        $apiKey,
        ProjectUserAdapter $projectUserAdapter
    ) {
        parent::__construct($apiKey);

        $this->projectUserAdapter = $projectUserAdapter;
    }

    /**
     * @param ProjectUser $projectUser
     */
    public function create(ProjectUser $projectUser)
    {
        $body = $this->encodeRequestData([
            'project_user' => $this->projectUserAdapter->serialize($projectUser)
        ]);

        $response = $this->client->request(
            'POST',
            $this->url('project_users'),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->projectUserAdapter->transform(Arr::get($data, 'data'), $projectUser);
    }

    /**
     * @param ProjectUser $projectUser
     */
    public function update(ProjectUser $projectUser)
    {
        $body = $this->encodeRequestData([
            'project_user' => $this->projectUserAdapter->serialize($projectUser)
        ]);

        $response = $this->client->request(
            'PUT',
            $this->url('project_users/{id}', ['id' => $projectUser->id]),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->projectUserAdapter->transform(Arr::get($data, 'data'), $projectUser);
    }

    /**
     * @param integer|ProjectUser $projectUser
     */
    public function destroy($projectUser)
    {
        if ($projectUser instanceof ProjectUser) {
            $id = $projectUser->id;
        } else {
            $id = $projectUser;
        }

        $this->client->request(
            'DELETE',
            $this->url('project_users/{id}', ['id' => $id])
        );
    }
}
