<?php

namespace Brainfab\Toggl\Adapters;

use Brainfab\Toggl\Entities\TimeEntry;
use Brainfab\Toggl\Toggl;
use Carbon\Carbon;
use Brainfab\Toggl\Support\Arr;

/**
 * Class TimeEntryAdapter.
 */
class TimeEntryAdapter
{
    protected $fillable = [
        'description', 'tags', 'duration', 'start', 'pid', 'created_with'
    ];

    /**
     * Transform API result to entity object.
     *
     * @param array     $data   API result.
     * @param TimeEntry $object Refresh object data.
     *
     * @return TimeEntry
     */
    public function transform(array $data, TimeEntry $object = null)
    {
        if (null === $object) {
            $object = new TimeEntry();
        }

        $object->id = Arr::get($data, 'id');
        $object->start = Carbon::createFromFormat(Toggl::ISO8601, Arr::get($data, 'start'));
        $object->stop = Carbon::createFromFormat(Toggl::ISO8601, Arr::get($data, 'stop'));
        $object->description = Arr::get($data, 'description');
        $object->wid = Arr::get($data, 'wid');
        $object->pid = Arr::get($data, 'pid');
        $object->tid = Arr::get($data, 'tid');
        $object->billable = Arr::get($data, 'billable');
        $object->duration = Arr::get($data, 'duration');
        $object->createdWith = Arr::get($data, 'created_with');
        $object->tags = Arr::get($data, 'tags');
        $object->duronly = Arr::get($data, 'duronly');
        $object->at = !empty($data['at']) ? Carbon::createFromFormat(Toggl::ISO8601, $data['at']) : null;

        return $object;
    }

    /**
     * Serialize object to array.
     *
     * @param TimeEntry $object
     *
     * @return array
     */
    public function serialize(TimeEntry $object)
    {
        return Arr::only((array)$object, $this->fillable);
    }
}
