[Toggl](https://toggl.com) API PHP SDK
=====================================

[![Latest Stable Version](https://poser.pugx.org/brainfab/toggl_sdk/v/stable)](https://packagist.org/packages/brainfab/toggl_sdk) [![Total Downloads](https://poser.pugx.org/brainfab/toggl_sdk/downloads)](https://packagist.org/packages/brainfab/toggl_sdk) [![Latest Unstable Version](https://poser.pugx.org/brainfab/toggl_sdk/v/unstable)](https://packagist.org/packages/brainfab/toggl_sdk) [![License](https://poser.pugx.org/brainfab/toggl_sdk/license)](https://packagist.org/packages/brainfab/toggl_sdk)

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
