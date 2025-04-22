<?php

declare(strict_types=1);

namespace Konekt\ExtLogger\Utils\Symfony;

use Konekt\ExtLogger\Contracts\ExtPsrLogger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\Output;

class OutputRedirector extends Output
{
    private LoggerInterface|ExtPsrLogger $logger;

    public function __construct(
        LoggerInterface|ExtPsrLogger $logger,
        ?int $verbosity = self::VERBOSITY_NORMAL,
        bool $decorated = false,
        ?OutputFormatterInterface $formatter = null
    ) {
        parent::__construct($verbosity, $decorated, $formatter);
        $this->logger = $logger;
    }

    protected function doWrite(string $message, bool $newline): void
    {
        $this->logger->info($message);
    }
}
