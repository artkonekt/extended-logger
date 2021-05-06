<?php

declare(strict_types=1);

/**
 * Contains the PythonLoggerTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-02-05
 *
 */

namespace Konekt\ExtLogger\Tests;

use Carbon\Carbon;
use Exception;
use Konekt\ExtLogger\Loggers\PythonLogger;
use Konekt\ExtLogger\Tests\Examples\ExampleException;
use PHPUnit\Framework\TestCase;

class PythonLoggerTest extends TestCase
{
    /** @test */
    public function it_logs_in_json_format()
    {
        Carbon::setTestNow('2021-01-21 14:00:00');
        $this->getLogger()->info('Hey');

        $this->expectOutputString('{"asctime":"2021-01-21T14:00:00.000000Z","name":"test","levelname":"INFO","message":"Hey"}' . "\n");
    }

    /** @test */
    public function it_can_log_ok_level_messages()
    {
        Carbon::setTestNow('2021-01-23 09:00:00');
        $this->getLogger()->ok('Success');

        $this->expectOutputString('{"asctime":"2021-01-23T09:00:00.000000Z","name":"test","levelname":"OK","message":"Success"}' . "\n");
    }

    /** @test */
    public function it_logs_the_service_name_as_name()
    {
        Carbon::setTestNow('2021-02-03 09:00:00');
        $this->getLogger('svcname')->error('Meeh');

        $this->expectOutputString('{"asctime":"2021-02-03T09:00:00.000000Z","name":"svcname","levelname":"ERROR","message":"Meeh"}' . "\n");
    }

    /** @test */
    public function it_logs_exceptions_if_an_exception_object_is_passed_as_the_value_under_exception_array_key()
    {
        Carbon::setTestNow('2021-05-06 16:47:00');
        $this->getLogger('cicciolina')->error('Meeh', ['exception' => new \LogicException('This is illogical!')]);

        $this->expectOutputString('{"exception":{"class":"LogicException","message":"This is illogical!"},"asctime":"2021-05-06T16:47:00.000000Z","name":"cicciolina","levelname":"ERROR","message":"Meeh"}' . "\n");
    }

    /** @test */
    public function it_logs_the_fqcn_of_exceptions()
    {
        Carbon::setTestNow('2021-05-06 16:47:00');
        $this->getLogger('cicciolina')->error('Meeh', ['exception' => new ExampleException('Yo!')]);

        $this->expectOutputString('{"exception":{"class":"Konekt\\\\ExtLogger\\\\Tests\\\\Examples\\\\ExampleException","message":"Yo!"},"asctime":"2021-05-06T16:47:00.000000Z","name":"cicciolina","levelname":"ERROR","message":"Meeh"}' . "\n");
    }

    /** @test */
    public function it_returns_scalars_passed_as_exception_without_change()
    {
        Carbon::setTestNow('2021-05-06 16:47:00');
        $this->getLogger('cicciolina')->error('Meeh', ['exception' => 'Hey!']);

        $this->expectOutputString('{"exception":"Hey!","asctime":"2021-05-06T16:47:00.000000Z","name":"cicciolina","levelname":"ERROR","message":"Meeh"}' . "\n");
    }

    /** @test */
    public function it_logs_the_classname_of_non_exception_objects_passed_as_exception()
    {
        Carbon::setTestNow('2021-05-06 16:47:00');
        $this->getLogger('cicciolina')->error('Meeh', ['exception' => new \DateTime()]);

        $this->expectOutputString('{"exception":{"class":"DateTime","message":"The passed object to the logger is not an exception"},"asctime":"2021-05-06T16:47:00.000000Z","name":"cicciolina","levelname":"ERROR","message":"Meeh"}' . "\n");
    }

    /** @test */
    public function it_can_log_to_an_output_file()
    {
        $outfile = tempnam(sys_get_temp_dir(), 'extlogtest_');
        try {
            Carbon::setTestNow('2021-01-18 07:30:00');
            $logger = $this->getLogger();
            $logger->useFileAsOutput($outfile);
            $logger->warning('Meouw');

            $this->assertStringEqualsFile(
                $outfile,
                '{"asctime":"2021-01-18T07:30:00.000000Z","name":"test","levelname":"WARNING","message":"Meouw"}' . "\n"
            );
        } finally {
            unlink($outfile);
        }
    }

    /** @test */
    public function it_appends_logs_to_the_given_output_file()
    {
        $outfile = tempnam(sys_get_temp_dir(), 'extlogtesta_');
        try {
            Carbon::setTestNow('2021-01-15 06:45:00');
            $logger = $this->getLogger();
            $logger->useFileAsOutput($outfile);
            $logger->debug('Cow is coming');
            $logger->warning('Moooh!!!');

            $this->assertStringEqualsFile(
                $outfile,
                '{"asctime":"2021-01-15T06:45:00.000000Z","name":"test","levelname":"DEBUG","message":"Cow is coming"}' . "\n" .
                '{"asctime":"2021-01-15T06:45:00.000000Z","name":"test","levelname":"WARNING","message":"Moooh!!!"}' . "\n"
            );
        } finally {
            unlink($outfile);
        }
    }

    private function getLogger(string $serviceName = 'test'): PythonLogger
    {
        return new PythonLogger($serviceName);
    }
}
