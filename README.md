# Extended PSR Logger

[![Tests](https://img.shields.io/github/actions/workflow/status/artkonekt/extended-logger/tests.yml?master&style=flat-square)](https://github.com/artkonekt/extended-logger/actions?query=workflow%3Atests)
[![Packagist Stable Version](https://img.shields.io/packagist/v/konekt/extended-logger.svg?style=flat-square&label=stable)](https://packagist.org/packages/konekt/extended-logger)
[![Packagist downloads](https://img.shields.io/packagist/dt/konekt/extended-logger.svg?style=flat-square)](https://packagist.org/packages/konekt/extended-logger)
[![StyleCI](https://styleci.io/repos/336267231/shield?branch=master)](https://styleci.io/repos/336267231)
[![MIT Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

The main purpose of this logger is to add `OK` level besides the usual `debug`, `info`, `warning`
levels defined by PSR-3.

The scope of `OK` is to be able to send semantic "positive" logs to tools like Datadog in order to
watch the successful execution of jobs. This can be useful for setting up log based hearbeat
monitoring.

## Usage

> **IMPORTANT**: This library requires PHP 8.1+

Refer to the [Documentation](https://konekt.dev/extended-logger/docs) for more details.
