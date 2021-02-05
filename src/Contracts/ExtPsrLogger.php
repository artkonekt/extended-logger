<?php

declare(strict_types=1);

/**
 * Contains the ExtPsrLogger interface.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-02-05
 *
 */

namespace Konekt\ExtLogger\Contracts;

use Psr\Log\LoggerInterface;

interface ExtPsrLogger extends LoggerInterface
{
    /** Logs a successful event */
    public function ok(string $message, array $context = []): void;
}
