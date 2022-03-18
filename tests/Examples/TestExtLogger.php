<?php

declare(strict_types=1);

/**
 * Contains the TestExtLogger class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-02-05
 *
 */

namespace Konekt\ExtLogger\Tests\Examples;

use Konekt\ExtLogger\Contracts\ExtPsrLogger;
use Konekt\ExtLogger\ExtLogLevel;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerTrait;

class TestExtLogger implements ExtPsrLogger
{
    use LoggerTrait;

    public const SIMPLE_DATE = "Y-m-d\TH:i:s.uP";

    private string $dateFormat = self::SIMPLE_DATE;

    private array $recordsByLevel = [];

    private array $records = [];

    public function ok(string|\Stringable $message, array $context = []): void
    {
        $this->log(ExtLogLevel::OK, $message, $context);
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        if (!in_array($level, (new \ReflectionClass(ExtLogLevel::class))->getConstants())) {
            throw new InvalidArgumentException("Unknown level $level");
        }

        $record = [
            'level' => $level,
            'message' => $message,
            'context' => $context,
        ];

        $this->recordsByLevel[$record['level']][] = $record;
        $this->records[] = $record;
    }

    public function getLogs(): array
    {
        $logs = [];

        foreach ($this->records as $record) {
            $logs[] = $record['level'] . ' ' . $this->psr3RuleProcessor($record)['message'];
        }

        return $logs;
    }

    private function psr3RuleProcessor(array $record): array
    {
        if (!is_string($record['message']) || !str_contains($record['message'], '{')) {
            return $record;
        }

        $replacements = [];
        foreach ($record['context'] as $key => $val) {
            $placeholder = '{' . $key . '}';
            if (!str_contains($record['message'], $placeholder)) {
                continue;
            }

            if (is_null($val) || is_scalar($val) || (is_object($val) && method_exists($val, "__toString"))) {
                $replacements[$placeholder] = $val;
            } elseif ($val instanceof \DateTimeInterface) {
                if (!$this->dateFormat && $val instanceof \DateTimeImmutable) {
                    // handle monolog dates using __toString if no specific dateFormat was asked for
                    // so that it follows the useMicroseconds flag
                    $replacements[$placeholder] = (string) $val;
                } else {
                    $replacements[$placeholder] = $val->format($this->dateFormat ?: static::SIMPLE_DATE);
                }
            } elseif (is_object($val)) {
                $replacements[$placeholder] = '[object ' . get_class($val) . ']';
            } elseif (is_array($val)) {
                $replacements[$placeholder] = 'array' . json_encode($val);
            } else {
                $replacements[$placeholder] = '[' . gettype($val) . ']';
            }
        }

        $record['message'] = strtr($record['message'], $replacements);

        return $record;
    }
}
