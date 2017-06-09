<?php

namespace Brainfab\Toggl\Managers;

use Brainfab\Toggl\Adapters\ClientAdapter;
use Brainfab\Toggl\Adapters\ProjectAdapter;
use Brainfab\Toggl\Entities\Client;
use Brainfab\Toggl\Entities\Project;
use Brainfab\Toggl\Support\Arr;
use Brainfab\Toggl\Support\Collection;
use GuzzleHttp\RequestOptions;

/**
 * Class ClientManager.
 */
class ClientManager extends BaseManager
{
    /**
     * @var ClientAdapter
     */
    protected $clientAdapter;

    /**
     * @var ProjectAdapter
     */
    protected $projectAdapter;

    /**
     * ClientManager constructor.
     *
     * @param string         $apiKey
     * @param ClientAdapter  $clientAdapter
     * @param ProjectAdapter $projectAdapter
     */
    public function __construct(
        $apiKey,
        ClientAdapter $clientAdapter,
        ProjectAdapter $projectAdapter
    ) {
        parent::__construct($apiKey);

        $this->clientAdapter = $clientAdapter;
        $this->projectAdapter = $projectAdapter;
    }

    /**
     * @return Collection|Client[]
     */
    public function all()
    {
        $response = $this->client->get($this->url('clients'));
        $data = $this->decodeResponse($response);

        $result = new Collection();
        foreach ($data as $itemData) {
            $result[] = $this->clientAdapter->transform($itemData);
        }

        return $result;
    }

    /**
     * @param integer|Client $client
     * @param boolean $active
     *
     * @return Collection|Project[]
     */
    public function projects($client, $active = null)
    {
        $id = $client instanceof Client ? $client->id : $client;

        $response = $this->client->get($this->url('clients/{id}/projects', ['id' => $id, 'active' => $active]));
        $data = $this->decodeResponse($response);

        $result = new Collection();
        foreach ($data as $itemData) {
            $result[] = $this->projectAdapter->transform($itemData);
        }

        return $result;
    }

    /**
     * @return Client
     */
    public function find($id)
    {
        $response = $this->client->get($this->url('clients/{id}', ['id' => $id]));
        $data = Arr::get($this->decodeResponse($response), 'data');

        return $this->clientAdapter->transform($data);
    }

    /**
     * @param Client $client
     */
    public function create(Client $client)
    {
        $body = $this->encodeRequestData([
            'client' => $this->clientAdapter->serialize($client)
        ]);

        $response = $this->client->request(
            'POST',
            $this->url('clients'),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->clientAdapter->transform(Arr::get($data, 'data'), $client);
    }

    /**
     * @param Client $client
     */
    public function update(Client $client)
    {
        $body = $this->encodeRequestData([
            'client' => $this->clientAdapter->serialize($client)
        ]);

        $response = $this->client->request(
            'PUT',
            $this->url('clients/{id}', ['id' => $client->id]),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->clientAdapter->transform(Arr::get($data, 'data'), $client);
    }

    /**
     * @param integer|Client $client
     */
    public function destroy($client)
    {
        if ($client instanceof Client) {
            $id = $client->id;
        } else {
            $id = $client;
        }

        $this->client->request(
            'DELETE',
            $this->url('clients/{id}', ['id' => $id])
        );
    }
}
