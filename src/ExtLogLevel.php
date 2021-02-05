<?php

declare(strict_types=1);

/**
 * Contains the ExtLogLevel class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-02-05
 *
 */

namespace Konekt\ExtLogger;

use Psr\Log\LogLevel;

class ExtLogLevel extends LogLevel
{
    public const OK = 'ok';
}
