# The Python JSON Logger

The Python JSON log format is supported by many log management services, because machines can easily
parse and analyze this standard, structured format. JSON format is also easily customizable to
include any attributes you decide to add to each log format, so you won’t need to update your log
processing pipelines every time you add or remove an attribute from your log format.

> See also: [Log in JSON format](https://www.datadoghq.com/blog/python-logging-best-practices/#log-in-json-format)
> and [Python JSON Logger](https://github.com/madzak/python-json-logger)

This library offers the `PythonLogger` class that is a PSR-3 compatible logger, that generates the
same format as the [Python JSON Logger](https://github.com/madzak/python-json-logger) does.

## Usage

```php
$logger = new \Konekt\ExtLogger\Loggers\PythonLogger('service-name');
$logger->info('Hello snake');
// Output:
// {"asctime":"2021-02-05T16:07:49.677422Z","name":"service-name","levelname":"INFO","message":"Hello snake"}
```

The argument passed to the construction is the name of the service/component, ie. the logical unit
that the logs belong to. This can be very useful for grouping and filtering logs coming from a
specific source.

### Logging To Files

The `PythonLogger` implements the `FileCapableLogger` interface. This consists of a single method:

```php
$logger->useFileAsOutput('/var/log/some-service.log');
```

Calling this method will instruct the logger to write the log lines to the given file instead of
writing them to stdout.

## Adding Extra Attributes

PSR-3 has support for passing extra attributes to the log lines. These attributes will show up in
the JSON output as well:

```php
 $logger->info('Converted image 9W7u8d02kL3', ['host' => 'appserver08']);
// Output:
// {"host":"appserver08","asctime":"2021-02-05T16:16:47.414460Z","name":"service-name","levelname":"INFO","message":"Converted image 9W7u8d02kL3"}
```

---

**Next**: [Laravel Command Logging &raquo;](laravel-command-logging.md)
