# Installation

## PSR Log Compatibility

This package is compatible with the [PSR Log](https://github.com/php-fig/log)
package according to the table below:

| PSR Log | EXT Logger (this package) |
|---------|---------------------------|
| 1.x     | 1.x                       |
| 2.x     | 2.x                       |
| 3.x     | 3.x                       |


To install the package, use composer:

```bash
composer require konekt/extended-logger
```

## Usage

```php
$logger = new \Konekt\ExtLogger\Loggers\PythonLogger('some_erpsync');
// Do the heavy operation
$logger->ok('Serpa import was successful. Imported 4011 products. There are 4011 enabled products.');
```

The log processor of your choice (Datadog, Newrelic, Papertrail, etc) can recognize it as a
structured data:

![ok_logs_in_datadog](ok_logs_in_datadog.png)

---

**Next**: [Python Logger &raquo;](python-logger.md)
