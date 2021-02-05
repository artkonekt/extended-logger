<?php

declare(strict_types=1);

/**
 * Contains the InterfaceTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-02-05
 *
 */

namespace Konekt\ExtLogger\Tests;

use Konekt\ExtLogger\Contracts\ExtPsrLogger;
use Konekt\ExtLogger\Tests\Examples\TestExtLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\Test\LoggerInterfaceTest;

class InterfaceTest extends LoggerInterfaceTest
{
    private ?ExtPsrLogger $logger = null;

    public function testThrowsOnInvalidLevel()
    {
        $this->expectException(InvalidArgumentException::class);

        $logger = $this->getLogger();
        $logger->log('invalid level', 'Foo');
    }

    public function getLogger()
    {
        if (null === $this->logger) {
            $this->logger = new TestExtLogger();
        }

        return $this->logger;
    }

    public function getLogs()
    {
        return $this->getLogger()->getLogs();
    }
}
