# logger
PHP PSR-3 compatible loggers

[![Latest Stable Version](https://poser.pugx.org/phyrexia/log/v/stable)](https://packagist.org/packages/phyrexia/log)
[![License](https://poser.pugx.org/phyrexia/log/license)](https://packagist.org/packages/phyrexia/log)

## Requirements

- PHP >= 5.3
- Composer [psr/log](https://packagist.org/packages/psr/log) ^1.0

## Installation

Install directly via [Composer](https://getcomposer.org):
```bash
$ composer require phyrexia/log
```

## Basic Usage

```php
<?php
require 'vendor/autoload.php';

use Phyrexia\Log\FileLogger;

//Instantiate a FileLogger logger
$logger = new FileLogger('/tmp/some_file.log');

//Log an error
$logger->error('An error occured! :(');

//Log an info
$logger->info('It works! :)');

...
```
