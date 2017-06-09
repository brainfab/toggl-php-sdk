<?php

namespace Brainfab\Toggl\Adapters;

use Brainfab\Toggl\Entities\Tag;
use Brainfab\Toggl\Support\Arr;

/**
 * Class TagAdapter.
 */
class TagAdapter
{
    protected $fillable = [
        'name', 'wid'
    ];

    /**
     * Transform API result to entity object.
     *
     * @param array  $data   API result.
     * @param Tag    $object Refresh object data.
     *
     * @return Tag
     */
    public function transform(array $data, Tag $object = null)
    {
        if (null === $object) {
            $object = new Tag();
        }

        $properties = [
            'name', 'wid', 'id'
        ];

        foreach ($properties as $property) {
            $object->{$property} = Arr::get($data, $property);
        }

        return $object;
    }

    /**
     * Serialize object to array.
     *
     * @param Tag $object
     *
     * @return array
     */
    public function serialize(Tag $object)
    {
        return Arr::only((array)$object, $this->fillable);
    }
}
