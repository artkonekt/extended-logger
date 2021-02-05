<?php

declare(strict_types=1);

/**
 * Contains the LaravelCommandLogger class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-02-05
 *
 */

namespace Konekt\ExtLogger\Loggers;

use Exception;
use Illuminate\Console\Command;
use Konekt\ExtLogger\Contracts\ExtPsrLogger;
use Konekt\ExtLogger\ExtLogLevel;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;

/**
 * Logs messages to the given commands output using colors, verbosity, etc
 */
class LaravelCommandLogger implements ExtPsrLogger
{
    use LoggerTrait;

    private const WRITE_LINE = 'line';
    private const WRITE_COMMENT = 'comment';
    private const WRITE_INFO = 'info';
    private const WRITE_WARN = 'warn';
    private const WRITE_ERROR = 'error';
    private const WRITE_ALERT = 'alert';

    private array $formatLevelMap = [
        LogLevel::EMERGENCY => self::WRITE_ALERT,
        LogLevel::ALERT     => self::WRITE_ALERT,
        LogLevel::CRITICAL  => self::WRITE_ERROR,
        LogLevel::ERROR     => self::WRITE_ERROR,
        LogLevel::WARNING   => self::WRITE_WARN,
        LogLevel::NOTICE    => self::WRITE_LINE,
        LogLevel::INFO      => self::WRITE_INFO,
        LogLevel::DEBUG     => self::WRITE_COMMENT,
        ExtLogLevel::OK     => self::WRITE_INFO,
    ];

    private Command $command;

    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    public function ok(string $message, array $context = []): void
    {
        $this->log(ExtLogLevel::OK, $message, $context);
    }

    public function log($level, $message, array $context = [])
    {
        $exception = $context['exception'] ?? null;
        if ($exception instanceof Exception) {
            $message .= ' | ' . get_class($exception) . ': ' . $exception->getMessage();
        }

        $writeInStyle = $this->formatLevelMap[$level] ?? self::WRITE_LINE;
        $this->command->{$writeInStyle}($message);
    }
}
