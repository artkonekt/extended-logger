<?php

declare(strict_types=1);

/**
 * Contains the HasExtendedLogger trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-02-05
 *
 */

namespace Konekt\ExtLogger\Utils\Laravel;

use Konekt\ExtLogger\Contracts\ExtPsrLogger;
use Konekt\ExtLogger\Contracts\FileCapableLogger;
use Konekt\ExtLogger\Loggers\LaravelCommandLogger;
use Konekt\ExtLogger\Loggers\PythonLogger;

/**
 * Use this trait on Laravel console commands to be able to log either
 * to the nice & decorated console output for manual operations, or
 * to log to a file based logger for automated, batch operations
 */
trait HasContextualLogger
{
    /*
     * Add these two lines two your command's signature:
     *
     *  {--O|output= : The filename to write log messages to. Batch mode must be enabled.}
     *  {--B|batch-mode : Logs in JSON format if set}
     */

    private ExtPsrLogger $logger;

    private function initLogger(): void
    {
        if ($this->isInBatchMode()) {
            $this->logger = $this->getBatchLogger();

            if ($this->logger instanceof FileCapableLogger) {
                $this->redirectLogOutputToFileIfNecessary($this->logger);
            }

            return;
        }

        $this->logger = new LaravelCommandLogger($this);
    }

    private function getBatchLogger(): ExtPsrLogger
    {
        if (method_exists($this, 'createBatchLogger')) {
            return $this->createBatchLogger();
        }

        if (property_exists($this, 'batchLoggerClass')) {
            $class = $this->batchLoggerClass;
            return new $class();
        }

        if (property_exists($this, 'serviceNameForLogs')) {
            $serviceName = $this->serviceNameForLogs;
        } else {
            $serviceName = $this->name ?? $this::class;
        }

        return new PythonLogger($serviceName);
    }

    private function redirectLogOutputToFileIfNecessary(FileCapableLogger $logger): void
    {
        $optionName = property_exists($this, 'logToFileOptionName') ? $this->logToFileOptionName : 'output';

        if (null !== $this->option($optionName)) {
            $logger->useFileAsOutput($this->option($optionName));
        }
    }

    private function isInBatchMode(): bool
    {
        $optionName = property_exists($this, 'batchModeOptionName') ? $this->batchModeOptionName : 'batch-mode';

        return $this->option($optionName);
    }
}
