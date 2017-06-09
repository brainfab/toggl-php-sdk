<?php

namespace Brainfab\Toggl\Adapters;

use Brainfab\Toggl\Entities\Project;
use Brainfab\Toggl\Toggl;
use Carbon\Carbon;
use Brainfab\Toggl\Support\Arr;

/**
 * Class ProjectAdapter.
 */
class ProjectAdapter
{
    protected $fillable = [
        'name', 'template_id', 'wid', 'is_private', 'cid', 'color'
    ];

    /**
     * Transform API result to entity object.
     *
     * @param array   $data   API result.
     * @param Project $object Refresh object data.
     *
     * @return Project
     */
    public function transform(array $data, Project $object = null)
    {
        if (null === $object) {
            $object = new Project();
        }

        $object->id = Arr::get($data, 'id');
        $object->name = Arr::get($data, 'name');
        $object->wid = Arr::get($data, 'wid');
        $object->cid = Arr::get($data, 'cid');
        $object->active = Arr::get($data, 'active');
        $object->isPrivate = Arr::get($data, 'is_private');
        $object->template = Arr::get($data, 'template');
        $object->templateId = Arr::get($data, 'template_id');
        $object->billable = Arr::get($data, 'billable');
        $object->autoEstimates = Arr::get($data, 'auto_estimates');
        $object->estimatedHours = Arr::get($data, 'estimated_hours');
        $object->color = Arr::get($data, 'color');
        $object->rate = Arr::get($data, 'rate');
        $object->at = !empty($data['at']) ? Carbon::createFromFormat(Toggl::ISO8601, $data['at']) : null;

        return $object;
    }

    /**
     * Serialize object to array.
     *
     * @param Project $object
     *
     * @return array
     */
    public function serialize(Project $object)
    {
        return Arr::only((array)$object, $this->fillable);
    }
}
