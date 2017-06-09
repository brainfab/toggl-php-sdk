<?php

require_once 'vendor/autoload.php';

use Brainfab\Toggl\Toggl;

$apiKey = 'your api key';
$toggl = new Toggl($apiKey);

$account = $toggl->account()->me();

echo $account->fullname;
