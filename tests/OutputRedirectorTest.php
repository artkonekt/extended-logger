<?php

declare(strict_types=1);

namespace Konekt\ExtLogger\Tests;

use Carbon\Carbon;
use Konekt\ExtLogger\Loggers\PythonLogger;
use Konekt\ExtLogger\Utils\Symfony\OutputRedirector;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class OutputRedirectorTest extends TestCase
{
    #[Test] public function it_can_redirect_the_output_to_the_configured_logger()
    {
        $outfile = tempnam(sys_get_temp_dir(), 'extlogtest_');
        try {
            Carbon::setTestNow('2025-04-22 07:30:00');
            $logger = new PythonLogger('dog');
            $logger->useFileAsOutput($outfile);
            $output = new OutputRedirector($logger);
            $output->write('Huff');

            $this->assertStringEqualsFile(
                $outfile,
                '{"asctime":"2025-04-22T07:30:00.000000Z","name":"dog","levelname":"INFO","message":"Huff"}' . "\n"
            );
        } finally {
            unlink($outfile);
        }
    }
}
