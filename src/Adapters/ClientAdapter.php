<?php

namespace Brainfab\Toggl\Adapters;

use Brainfab\Toggl\Entities\Client;
use Brainfab\Toggl\Toggl;
use Carbon\Carbon;
use Brainfab\Toggl\Support\Arr;

/**
 * Class ClientAdapter.
 */
class ClientAdapter
{
    protected $fillable = [
        'name', 'notes', 'wid'
    ];

    /**
     * Transform API result to entity object.
     *
     * @param array  $data   API result.
     * @param Client $object Refresh object data.
     *
     * @return Client
     */
    public function transform(array $data, Client $object = null)
    {
        if (null === $object) {
            $object = new Client();
        }

        $properties = [
            'id', 'name', 'notes', 'wid'
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
     * @param Client $object
     *
     * @return array
     */
    public function serialize(Client $object)
    {
        return Arr::only((array)$object, $this->fillable);
    }
}
