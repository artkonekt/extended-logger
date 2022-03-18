<?php

declare(strict_types=1);

/**
 * Contains the PythonLogger class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-02-05
 *
 */

namespace Konekt\ExtLogger\Loggers;

use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Closure;
use Konekt\ExtLogger\Concerns\FormatsContextualExceptions;
use Konekt\ExtLogger\Contracts\ExtPsrLogger;
use Konekt\ExtLogger\Contracts\FileCapableLogger;
use Konekt\ExtLogger\ExtLogLevel;
use Psr\Log\LoggerTrait;

/**
 * Logs errors in "Python format" so that Datadog can beautifully parse it
 */
class PythonLogger implements ExtPsrLogger, FileCapableLogger
{
    use LoggerTrait;
    use FormatsContextualExceptions;

    private string $serviceName;

    private CarbonTimeZone $timeZone;

    private Closure $output;

    public function __construct(string $serviceName, string $timeZone = 'UTC')
    {
        $this->serviceName = $serviceName;
        $this->timeZone = new CarbonTimeZone($timeZone);
        $this->output = fn (string $line) => print("$line\n");
    }

    public function useFileAsOutput(string $file): void
    {
        $this->output = fn (string $line) => file_put_contents($file, "$line\n", FILE_APPEND);
    }

    public function ok(string|\Stringable $message, array $context = []): void
    {
        $this->log(ExtLogLevel::OK, $message, $context);
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $context = $this->convertExceptionsToLoggableArray($context);

        $this->output->call($this, json_encode(array_merge($context, [
            'asctime' => Carbon::now($this->timeZone),
            'name' => $this->serviceName,
            'levelname' => strtoupper($level),
            'message' => $message
        ])));
    }
}
