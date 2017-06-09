<?php

namespace Brainfab\Toggl\Managers;

use Brainfab\Toggl\Adapters\AccountAdapter;
use Brainfab\Toggl\Entities\Account;
use Brainfab\Toggl\Support\Arr;
use GuzzleHttp\RequestOptions;

/**
 * Class AccountManager.
 */
class AccountManager extends BaseManager
{
    /**
     * @var AccountAdapter
     */
    protected $accountAdapter;

    /**
     * AccountManager constructor.
     *
     * @param string         $apiKey
     * @param AccountAdapter $accountAdapter
     */
    public function __construct(
        $apiKey,
        AccountAdapter $accountAdapter
    ) {
        parent::__construct($apiKey);

        $this->accountAdapter = $accountAdapter;
    }

    /**
     * @param bool $withRelatedData
     *
     * @return Account
     */
    public function me($withRelatedData = false)
    {
        $response = $this->client->get($this->url('me'), [
            RequestOptions::QUERY => [
                'with_related_data' => $withRelatedData ? 'true' : 'false'
            ]
        ]);
        $data = $this->decodeResponse($response);

        return $this->accountAdapter->transform($data);
    }

    /**
     * @param Account $account
     */
    public function update(Account $account)
    {
        $body = $this->encodeRequestData([
            'user' => $this->accountAdapter->serialize($account)
        ]);

        $response = $this->client->request(
            'PUT',
            $this->url('me'),
            [
                RequestOptions::BODY => $body
            ]
        );

        $data = $this->decodeResponse($response);

        return $this->accountAdapter->transform(Arr::get($data, 'data'), $account);
    }

    /**
     * Reset API token.
     *
     * @return string New API token.
     */
    public function resetToken()
    {
        $response = $this->client->post($this->url('reset_token'));

        return trim($response->getBody()->getContents());
    }

    /**
     * Sign up new user.
     */
    public function signUp($email, $password)
    {
        $body = $this->encodeRequestData([
            'user' => [
                'email'    => $email,
                'password' => $password
            ]
        ]);

        $response = $this->client->request('POST', $this->url('signups'), [
            RequestOptions::BODY => $body
        ]);

        $data = $this->decodeResponse($response);

        return $this->accountAdapter->transform(Arr::get($data, 'data'));
    }

    /**
     * Destroy the session manually by sending an according request to the API.
     */
    public function destroySession()
    {
        $this->client->delete($this->url('sessions'));
    }
}
