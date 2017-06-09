<?php

namespace Brainfab\Toggl\Managers;

use Brainfab\Toggl\Adapters\TaskAdapter;
use Brainfab\Toggl\Entities\Task;
use Brainfab\Toggl\Support\Arr;
use GuzzleHttp\RequestOptions;

/**
 * Class TaskManager.
 */
class TaskManager extends BaseManager
{
    /**
     * @var TaskAdapter
     */
    protected $taskAdapter;

    /**
     * TaskManager constructor.
     *
     * @param string      $apiKey
     * @param TaskAdapter $taskAdapter
     */
    public function __construct(
        $apiKey,
        TaskAdapter $taskAdapter
    ) {
        parent::__construct($apiKey);

        $this->taskAdapter = $taskAdapter;
    }

    /**
     * @param Task $task
     */
    public function create(Task $task)
    {
        $body = $this->encodeRequestData([
            'task' => $this->taskAdapter->serialize($task)
        ]);

        $response = $this->client->request(
            'POST',
            $this->url('tasks'),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->taskAdapter->transform(Arr::get($data, 'data'), $task);
    }

    /**
     * @param int $id
     */
    public function find($id)
    {
        $response = $this->client->get($this->url('tasks/{id}', ['id' => $id]));

        $data = $this->decodeResponse($response);

        return $this->taskAdapter->transform(Arr::get($data, 'data'));
    }

    /**
     * @param Task $task
     */
    public function update(Task $task)
    {
        $body = $this->encodeRequestData([
            'task' => $this->taskAdapter->serialize($task)
        ]);

        $response = $this->client->request(
            'PUT',
            $this->url('tasks/{id}', ['id' => $task->id]),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->taskAdapter->transform(Arr::get($data, 'data'), $task);
    }

    /**
     * @param integer|Task $task
     */
    public function destroy($task)
    {
        if ($task instanceof Task) {
            $id = $task->id;
        } else {
            $id = $task;
        }

        $this->client->request(
            'DELETE',
            $this->url('tasks/{id}', ['id' => $id])
        );
    }
}
