[Toggl](https://toggl.com) API PHP SDK
=====================================

Installation
------------

Require this package with composer:

`` composer require brainfab/toggl_sdk ``

Usage example:
--------------

```php
require_once 'vendor/autoload.php';

use Brainfab\Toggl\Toggl;

$apiKey = 'your api key';

$toggl = new Toggl($apiKey);
$account = $toggl->account()->me();

echo $account->fullname;
```
