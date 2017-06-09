<?php

namespace Brainfab\Toggl\Adapters;

use Brainfab\Toggl\Entities\ProjectUser;
use Brainfab\Toggl\Entities\Task;
use Brainfab\Toggl\Toggl;
use Carbon\Carbon;
use Brainfab\Toggl\Support\Arr;

/**
 * Class TaskAdapter.
 */
class TaskAdapter
{
    protected $fillable = [
        'active', 'name', 'pid'
    ];

    /**
     * Transform API result to entity object.
     *
     * @param array $data   API result.
     * @param Task  $object Refresh object data.
     *
     * @return Task
     */
    public function transform(array $data, Task $object = null)
    {
        if (null === $object) {
            $object = new Task();
        }

        $properties = [
            'name', 'pid', 'wid', 'uid', 'active'
        ];

        foreach ($properties as $property) {
            $object->{$property} = Arr::get($data, $property);
        }

        $object->estimatedSeconds = Arr::get($data, 'estimated_seconds');
        $object->trackedSeconds = Arr::get($data, 'tracked_seconds');

        $object->at = !empty($data['at']) ? Carbon::createFromFormat(Toggl::ISO8601, $data['at']) : null;

        return $object;
    }

    /**
     * Serialize object to array.
     *
     * @param Task $object
     *
     * @return array
     */
    public function serialize(Task $object)
    {
        return Arr::only((array)$object, $this->fillable);
    }
}
