<?php

namespace Brainfab\Toggl\Managers;

use Brainfab\Toggl\Adapters\GroupAdapter;
use Brainfab\Toggl\Entities\Group;
use Brainfab\Toggl\Support\Arr;
use GuzzleHttp\RequestOptions;

/**
 * Class GroupManager.
 */
class GroupManager extends BaseManager
{
    /**
     * @var GroupAdapter
     */
    protected $groupAdapter;

    /**
     * GroupManager constructor.
     *
     * @param string       $apiKey
     * @param GroupAdapter $groupAdapter
     */
    public function __construct($apiKey, GroupAdapter $groupAdapter)
    {
        parent::__construct($apiKey);

        $this->groupAdapter = $groupAdapter;
    }

    /**
     * @return Group
     */
    public function find($id)
    {
        $response = $this->client->get($this->url('groups/{id}', ['id' => $id]));
        $data = Arr::get($this->decodeResponse($response), 'data');

        return $this->groupAdapter->transform($data);
    }

    /**
     * @param Group $group
     */
    public function create(Group $group)
    {
        $body = $this->encodeRequestData([
            'group' => $this->groupAdapter->serialize($group)
        ]);

        $response = $this->client->request(
            'POST',
            $this->url('groups'),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->groupAdapter->transform(Arr::get($data, 'data'), $group);
    }

    /**
     * @param Group $group
     */
    public function update(Group $group)
    {
        $body = $this->encodeRequestData([
            'group' => $this->groupAdapter->serialize($group)
        ]);

        $response = $this->client->request(
            'PUT',
            $this->url('groups/{id}', ['id' => $group->id]),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->groupAdapter->transform(Arr::get($data, 'data'), $group);
    }

    /**
     * @param integer|Group $group
     */
    public function destroy($group)
    {
        $id = $group instanceof Group ? $group->id : $group;

        $this->client->request(
            'DELETE',
            $this->url('groups/{id}', ['id' => $id])
        );
    }
}
