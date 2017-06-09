<?php

namespace Brainfab\Toggl\Adapters;

use Brainfab\Toggl\Entities\ProjectUser;
use Brainfab\Toggl\Toggl;
use Carbon\Carbon;
use Brainfab\Toggl\Support\Arr;

/**
 * Class ProjectUserAdapter.
 */
class ProjectUserAdapter
{
    protected $fillable = [
        'pid', 'uid', 'rate', 'manager'
    ];

    /**
     * Transform API result to entity object.
     *
     * @param array       $data   API result.
     * @param ProjectUser $object Refresh object data.
     *
     * @return ProjectUser
     */
    public function transform(array $data, ProjectUser $object = null)
    {
        if (null === $object) {
            $object = new ProjectUser();
        }

        $properties = [
            'id', 'pid', 'uid', 'wid', 'manager', 'rate'
        ];

        foreach ($properties as $property) {
            $object->{$property} = Arr::get($data, $property);
        }

        $object->at = !empty($data['at']) ? Carbon::createFromFormat(Toggl::ISO8601, $data['at']) : null;

        return $object;
    }

    /**
     * Serialize object to array.
     *
     * @param ProjectUser $object
     *
     * @return array
     */
    public function serialize(ProjectUser $object)
    {
        return Arr::only((array)$object, $this->fillable);
    }
}
