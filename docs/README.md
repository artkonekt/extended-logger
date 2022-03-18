# Extended PSR-3 Logging

This logger extends the default PSR-3 log levels (`debug`, `info`, `warning`, etc) with the new
`OK` level.

The scope of `OK` is to be able to send semantic "positive" logs to tools like Datadog in order to
watch the successful execution of jobs. This can be useful for setting up log based hearbeat
monitoring.

## Features

- PSR-3 compliant (extends it)
- Python (JSON) logger
- PHP 8+
- Laravel Command logger (logs to decorated Laravel console output)
- Trait for Laravel commands to either log to output or to a file in different formats based on
  the arguments passed to the console command

## Compatibility Chart

This package is compatible with the [PSR Log](https://github.com/php-fig/log) package.

The respective package versions are compatible as described:

| PSR Log | EXT Logger (this package) |
|---------|---------------------------|
| 1.x     | 1.x                       |
| 2.x     | 2.x                       |
| 3.x     | 3.x                       |

---

**Next**: [Installation &raquo;](installation.md)
