<?php

namespace Brainfab\Toggl\Adapters;

use Brainfab\Toggl\Entities\Workspace;
use Brainfab\Toggl\Support\Arr;
use Brainfab\Toggl\Support\Str;

/**
 * Class WorkspaceAdapter.
 */
class WorkspaceAdapter
{
    protected $fillable = [
        'default_currency', 'default_hourly_rate', 'name', 'only_admins_may_create_projects',
        'only_admins_see_billable_rates', 'rounding', 'rounding_minutes'
    ];

    /**
     * Transform API result to entity object.
     *
     * @param array     $data   API result.
     * @param Workspace $object Refresh object data.
     *
     * @return Workspace
     */
    public function transform(array $data, Workspace $object = null)
    {
        if (null === $object) {
            $object = new Workspace();
        }

        foreach ($data as $key => $value) {
            $prop = Str::camel($key);

            $object->{$prop} = $value;
        }

        return $object;
    }

    /**
     * Serialize object to array.
     *
     * @param Workspace $object
     *
     * @return array
     */
    public function serialize(Workspace $object)
    {
        return Arr::only((array)$object, $this->fillable);
    }
}
