<?php

namespace Brainfab\Toggl\Managers;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BaseManager.
 */
abstract class BaseManager
{
    /**
     * @var string
     */
    protected $host = 'https://www.toggl.com';

    /**
     * @var string
     */
    protected $urlPrefix = '';

    /**
     * @var string
     */
    protected $apiVersion = 'v8';

    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * BaseManager constructor.
     *
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;

        $this->client = new HttpClient([
            'base_uri' => $this->host,
            RequestOptions::AUTH => [$this->apiKey, 'api_token']
        ]);
    }

    /**
     * @param string $path
     * @param array  $params
     *
     * @return string
     */
    protected function url($path = '', array $params = [])
    {
        if (substr($path, 0, 1) === '/') {
            $path = substr($path, 1);
        }

        foreach ($params as $paramKey => $paramValue) {
            $pathVar = '{'.$paramKey.'}';
            if (strpos($path, $pathVar) !== false) {
                $path = str_replace($pathVar, $paramValue, $path);
                unset($params[$paramKey]);
            }
        }

        if (count($params)) {
            $path .= '?'.http_build_query($params);
        }

        return $this->urlPrefix.'/api/'.$this->apiVersion.'/'.$path;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    protected function decodeResponse(ResponseInterface $response)
    {
        $result = json_decode($response->getBody()->getContents(), true);
        return is_array($result) ? $result : [];
    }

    /**
     * @param array $data
     *
     * @return string
     */
    protected function encodeRequestData(array $data)
    {
        return json_encode($data);
    }
}
