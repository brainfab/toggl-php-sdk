<?php

namespace Brainfab\Toggl\Managers;

use GuzzleHttp\RequestOptions;

/**
 * Class ReportManager.
 *
 * @todo convert array to object
 */
class ReportManager extends BaseManager
{
    /**
     * @var string Default User agent parameter.
     */
    const USER_AGENT = 'Brainfab Toggl SDK';

    /**
     * @var string
     */
    protected $apiVersion = 'v2';

    /**
     * @var string
     */
    protected $urlPrefix = 'reports';

    /**
     * @param integer $workspaceId
     * @param array   $requestParams
     *
     * @return array
     */
    public function details($workspaceId, array $requestParams = [])
    {
        $query = [
            'user_agent'   => self::USER_AGENT,
            'workspace_id' => $workspaceId
        ];

        $query = array_merge($query, $requestParams);

        $response = $this->client->request('GET', $this->url('details'), [
            RequestOptions::QUERY => $query
        ]);

        $data = $this->decodeResponse($response);

        return $data;
    }

    /**
     * @param integer $workspaceId
     *
     * @return array
     */
    public function weekly($workspaceId)
    {
        $query = [
            'user_agent'   => self::USER_AGENT,
            'workspace_id' => $workspaceId
        ];

        $response = $this->client->request('GET', $this->url('weekly'), [
            RequestOptions::QUERY => $query
        ]);

        $data = $this->decodeResponse($response);

        return $data;
    }

    /**
     * @param integer $workspaceId
     *
     * @return array
     */
    public function summary($workspaceId)
    {
        $query = [
            'user_agent'   => self::USER_AGENT,
            'workspace_id' => $workspaceId
        ];

        $response = $this->client->request('GET', $this->url('summary'), [
            RequestOptions::QUERY => $query
        ]);

        $data = $this->decodeResponse($response);

        return $data;
    }
}
