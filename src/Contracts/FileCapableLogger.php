<?php

declare(strict_types=1);

/**
 * Contains the FileCapableLogger interface.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-02-05
 *
 */

namespace Konekt\ExtLogger\Contracts;

interface FileCapableLogger
{
    public function useFileAsOutput(string $file): void;
}
