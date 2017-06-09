<?php

namespace Brainfab\Toggl\Managers;

use Brainfab\Toggl\Adapters\TimeEntryAdapter;
use Brainfab\Toggl\Entities\TimeEntry;
use Brainfab\Toggl\Support\Arr;
use Brainfab\Toggl\Support\Collection;
use Brainfab\Toggl\Toggl;
use GuzzleHttp\RequestOptions;

/**
 * Class TimeEntryManager.
 */
class TimeEntryManager extends BaseManager
{
    /**
     * @var TimeEntryAdapter
     */
    protected $timeEntryAdapter;

    /**
     * TimeEntryManager constructor.
     *
     * @param string           $apiKey
     * @param TimeEntryAdapter $timeEntryAdapter
     */
    public function __construct($apiKey, TimeEntryAdapter $timeEntryAdapter)
    {
        parent::__construct($apiKey);

        $this->timeEntryAdapter = $timeEntryAdapter;
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     *
     * @return Collection|TimeEntry[]
     */
    public function getList(\DateTime $startDate = null, \DateTime $endDate = null)
    {
        $params = [];
        if ($startDate) {
            $params['start_date'] = $startDate->format(Toggl::ISO8601);
        }

        if ($endDate) {
            $params['end_date'] = $endDate->format(Toggl::ISO8601);
        }

        $response = $this->client->request('GET', $this->url('time_entries'), [
            'query' => $params
        ]);

        $data = $this->decodeResponse($response);

        $result = new Collection();
        foreach ($data as $itemData) {
            $result[] = $this->timeEntryAdapter->transform($itemData);
        }

        return $result;
    }

    /**
     * @param TimeEntry $timeEntry
     */
    public function create(TimeEntry $timeEntry)
    {
        $body = $this->encodeRequestData([
            'time_entry' => $this->timeEntryAdapter->serialize($timeEntry)
        ]);

        $response = $this->client->request(
            'POST',
            $this->url('time_entries'),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->timeEntryAdapter->transform(Arr::get($data, 'data'), $timeEntry);
    }

    /**
     * @param TimeEntry $timeEntry
     */
    public function start(TimeEntry $timeEntry)
    {
        $body = $this->encodeRequestData([
            'time_entry' => $this->timeEntryAdapter->serialize($timeEntry)
        ]);

        $response = $this->client->request(
            'POST',
            $this->url('time_entries/start'),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->timeEntryAdapter->transform(Arr::get($data, 'data'), $timeEntry);
    }

    /**
     * @param TimeEntry|int $timeEntry
     */
    public function stop($timeEntry)
    {
        $id = $timeEntry instanceof TimeEntry ? $timeEntry->id : $timeEntry;

        $response = $this->client->request(
            'PUT',
            $this->url('time_entries/{id}/stop', ['id' => $id])
        );

        $data = $this->decodeResponse($response);

        return $this->timeEntryAdapter->transform(Arr::get($data, 'data'), $timeEntry);
    }

    /**
     * @param int $id
     */
    public function find($id)
    {
        $response = $this->client->get($this->url('time_entries/{id}', ['id' => $id]));

        $data = $this->decodeResponse($response);

        return $this->timeEntryAdapter->transform(Arr::get($data, 'data'));
    }

    /**
     * Get running time entry.
     */
    public function current()
    {
        $response = $this->client->get($this->url('time_entries/current'));

        $data = $this->decodeResponse($response);

        return $this->timeEntryAdapter->transform(Arr::get($data, 'data'));
    }

    /**
     * @param TimeEntry $timeEntry
     */
    public function update(TimeEntry $timeEntry)
    {
        $body = $this->encodeRequestData([
            'time_entry' => $this->timeEntryAdapter->serialize($timeEntry)
        ]);

        $response = $this->client->request(
            'PUT',
            $this->url('time_entries/{id}', ['id' => $timeEntry->id]),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->timeEntryAdapter->transform(Arr::get($data, 'data'), $timeEntry);
    }

    /**
     * @param integer|TimeEntry $timeEntry
     */
    public function destroy($timeEntry)
    {
        if ($timeEntry instanceof TimeEntry) {
            $id = $timeEntry->id;
        } else {
            $id = $timeEntry;
        }

        $this->client->request(
            'DELETE',
            $this->url('time_entries/{id}', ['id' => $id])
        );
    }
}
