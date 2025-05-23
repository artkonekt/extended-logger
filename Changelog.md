# Extended PSR Logger Changelog

## 3.3.0
##### 2025-04-22

- Added the `OutputRedirector` class which is a generic symfony output class that writes the messages to the passed logger
- Added support for Carbon 3 (v3.8.4+)
- Changed the minimal Carbon version to v2.72.6

## 3.2.0
##### 2025-03-03

- Added PHP 8.4 support
- Dropped PHP 8.1 support

## 3.1.1
##### 2024-08-26

- Fixed possible type error when passing a value to the batch mode option like `--batch-mode=1`

## 3.1.0
##### 2024-01-25

- Changed the type of the private $logger in the `HasContextualLogger` trait from `LoggerInterface` to `LoggerInterface|ExtPsrLogger|ExtPsrLogger`

## 3.0.1
##### 2023-12-17

- Added PHP 8.3 Support

## 3.0.0
##### 2022-03-18

- Added compatibility with PSR Log v3
- Removed compatibility with PSR Log v2

## 2.0.1
##### 2023-12-17

- Added PHP 8.3 Support

## 2.0.0
##### 2022-03-18

- Added compatibility with PSR Log v2.0
- Removed compatibility with PSR Log v1

## 1.2.0
##### 2022-03-18

- Added PHP 8.1 Support

## 1.1.0
##### 2021-05-06

- Added the missing PSR compliant contextual exception handling to `PythonJsonLogger`

## 1.0.0
##### 2021-02-05

- Initial Release
- Extends PSR-3 with `OK` level
- Python (JSON) logger
- Laravel Command logger (logs to decorated Laravel console output)
- Trait for Laravel console command
