<?php

namespace Brainfab\Toggl\Managers;

use Brainfab\Toggl\Adapters\TagAdapter;
use Brainfab\Toggl\Entities\Tag;
use Brainfab\Toggl\Support\Arr;
use GuzzleHttp\RequestOptions;

/**
 * Class TagManager.
 */
class TagManager extends BaseManager
{
    /**
     * @var TagAdapter
     */
    protected $tagAdapter;

    /**
     * TagManager constructor.
     *
     * @param string     $apiKey
     * @param TagAdapter $tagAdapter
     */
    public function __construct(
        $apiKey,
        TagAdapter $tagAdapter
    ) {
        parent::__construct($apiKey);

        $this->tagAdapter = $tagAdapter;
    }

    /**
     * @param Tag $tag
     */
    public function create(Tag $tag)
    {
        $body = $this->encodeRequestData([
            'tag' => $this->tagAdapter->serialize($tag)
        ]);

        $response = $this->client->request(
            'POST',
            $this->url('tags'),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->tagAdapter->transform(Arr::get($data, 'data'), $tag);
    }

    /**
     * @param Tag $tag
     */
    public function update(Tag $tag)
    {
        $body = $this->encodeRequestData([
            'tag' => $this->tagAdapter->serialize($tag)
        ]);

        $response = $this->client->request(
            'PUT',
            $this->url('tags/{id}', ['id' => $tag->id]),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->tagAdapter->transform(Arr::get($data, 'data'), $tag);
    }

    /**
     * @param integer|Tag $tag
     */
    public function destroy($tag)
    {
        if ($tag instanceof Tag) {
            $id = $tag->id;
        } else {
            $id = $tag;
        }

        $this->client->request(
            'DELETE',
            $this->url('tags/{id}', ['id' => $id])
        );
    }
}
