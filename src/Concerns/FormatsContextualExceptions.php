<?php

declare(strict_types=1);

/**
 * Contains the FormatsContextualExceptions trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-05-06
 *
 */

namespace Konekt\ExtLogger\Concerns;

use Exception;

trait FormatsContextualExceptions
{
    private function convertExceptionsToLoggableArray(array $context): array
    {
        if (array_key_exists('exception', $context) && is_object($context['exception'])) {
            $exception = $context['exception'];

            $context['exception'] = [
                'class' => get_class($exception),
                'message' => $exception instanceof Exception ? $exception->getMessage() : 'The passed object to the logger is not an exception',
            ];
        }

        return $context;
    }
}
