<?php

namespace Brainfab\Toggl\Adapters;

use Brainfab\Toggl\Entities\Account;
use Brainfab\Toggl\Support\Collection;
use Brainfab\Toggl\Toggl;
use Carbon\Carbon;
use Brainfab\Toggl\Support\Arr;

/**
 * Class AccountAdapter.
 */
class AccountAdapter
{
    protected $fillable = [
        'fullname', 'email', 'send_product_emails', 'send_weekly_report', 'send_timer_notifications',
        'store_start_and_stop_time', 'beginning_of_week', 'timezone', 'timeofday_format', 'date_format',
        'current_password', 'password'
    ];

    /**
     * @var ProjectAdapter
     */
    protected $projectAdapter;

    /**
     * @var TagAdapter
     */
    protected $tagAdapter;

    /**
     * @var TaskAdapter
     */
    protected $taskAdapter;

    /**
     * @var WorkspaceAdapter
     */
    protected $workspaceAdapter;

    /**
     * @var ClientAdapter
     */
    protected $clientAdapter;

    /**
     * AccountAdapter constructor.
     *
     * @param ProjectAdapter   $projectAdapter
     * @param TagAdapter       $tagAdapter
     * @param TaskAdapter      $taskAdapter
     * @param WorkspaceAdapter $workspaceAdapter
     * @param ClientAdapter    $clientAdapter
     */
    public function __construct(
        ProjectAdapter $projectAdapter,
        TagAdapter $tagAdapter,
        TaskAdapter $taskAdapter,
        WorkspaceAdapter $workspaceAdapter,
        ClientAdapter $clientAdapter
    ) {
        $this->projectAdapter = $projectAdapter;
        $this->tagAdapter = $tagAdapter;
        $this->taskAdapter = $taskAdapter;
        $this->workspaceAdapter = $workspaceAdapter;
        $this->clientAdapter = $clientAdapter;
    }

    /**
     * Transform API result to entity object.
     *
     * @param array   $data   API result.
     * @param Account $object Refresh object data.
     *
     * @return Account
     */
    public function transform(array $data, Account $object = null)
    {
        if (null === $object) {
            $object = new Account();
        }

        $object->since = Arr::get($data, 'since');

        $data = Arr::get($data, 'data');
        $properties = [
            'id', 'email', 'fullname', 'language', 'timezone', 'retention'
        ];

        foreach ($properties as $property) {
            $object->{$property} = Arr::get($data, $property);
        }

        $object->at = !empty($data['at']) ? Carbon::createFromFormat(Toggl::ISO8601, $data['at']) : null;
        $object->createdAt = !empty($data['created_at']) ? Carbon::createFromFormat(Toggl::ISO8601, $data['created_at']) : null;
        $object->apiToken = Arr::get($data, 'api_token');
        $object->defaultWid = Arr::get($data, 'default_wid');
        $object->jqueryTimeofdayFormat = Arr::get($data, 'jquery_timeofday_format');
        $object->jqueryDateFormat = Arr::get($data, 'jquery_date_format');
        $object->timeofdayFormat = Arr::get($data, 'timeofday_format');
        $object->dateFormat = Arr::get($data, 'date_format');
        $object->storeStartAndStopTime = Arr::get($data, 'store_start_and_stop_time');
        $object->beginningOfWeek = Arr::get($data, 'beginning_of_week');
        $object->durationFormat = Arr::get($data, 'duration_format');
        $object->imageUrl = Arr::get($data, 'image_url');
        $object->newBlogPost = Arr::get($data, 'new_blog_post');

        $object->projects = new Collection();
        foreach (Arr::get($data, 'projects', []) as $item) {
            $object->projects[] = $this->projectAdapter->transform($item);
        }

        $object->tags = new Collection();
        foreach (Arr::get($data, 'tags', []) as $item) {
            $object->tags[] = $this->tagAdapter->transform($item);
        }

        $object->tasks = new Collection();
        foreach (Arr::get($data, 'tasks', []) as $item) {
            $object->tasks[] = $this->taskAdapter->transform($item);
        }

        $object->workspaces = new Collection();
        foreach (Arr::get($data, 'workspaces', []) as $item) {
            $object->workspaces[] = $this->workspaceAdapter->transform($item);
        }

        $object->clients = new Collection();
        foreach (Arr::get($data, 'clients', []) as $item) {
            $object->clients[] = $this->clientAdapter->transform($item);
        }

        return $object;
    }

    /**
     * Serialize object to array.
     *
     * @param Account $object
     *
     * @return array
     */
    public function serialize(Account $object)
    {
        return Arr::only((array)$object, $this->fillable);
    }
}
