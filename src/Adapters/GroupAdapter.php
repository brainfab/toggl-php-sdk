<?php

namespace Brainfab\Toggl\Adapters;

use Brainfab\Toggl\Entities\Group;
use Brainfab\Toggl\Toggl;
use Carbon\Carbon;
use Brainfab\Toggl\Support\Arr;

/**
 * Class GroupAdapter.
 */
class GroupAdapter
{
    protected $fillable = [
        'name', 'wid'
    ];

    /**
     * Transform API result to entity object.
     *
     * @param array $data   API result.
     * @param Group $object Refresh object data.
     *
     * @return Group
     */
    public function transform(array $data, Group $object = null)
    {
        if (null === $object) {
            $object = new Group();
        }

        $object->id = Arr::get($data, 'id');
        $object->name = Arr::get($data, 'name');
        $object->wid = Arr::get($data, 'wid');
        $object->at = !empty($data['at']) ? Carbon::createFromFormat(Toggl::ISO8601, $data['at']) : null;

        return $object;
    }

    /**
     * Serialize object to array.
     *
     * @param Group $object
     *
     * @return array
     */
    public function serialize(Group $object)
    {
        return Arr::only((array)$object, $this->fillable);
    }
}
