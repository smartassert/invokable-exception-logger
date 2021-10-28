<?php

declare(strict_types=1);

namespace SmartAssert\Tests\InvokableLoggingExceptionHandler;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use SmartAssert\InvokableLoggingExceptionHandler\LoggableException;
use SmartAssert\InvokableLoggingExceptionHandler\Logger;

class LoggerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testInvoke(): void
    {
        $this->testExecute(function (Logger $logger, \Throwable $exception) {
            ($logger)($exception);
        });
    }

    public function testLog(): void
    {
        $this->testExecute(function (Logger $logger, \Throwable $exception) {
            $logger->log($exception);
        });
    }

    private function testExecute(\Closure $executable): void
    {
        $exception = new \Exception('message', 99);

        $innerLogger = \Mockery::mock(LoggerInterface::class);
        $innerLogger
            ->shouldReceive('error')
            ->with((string) (new LoggableException($exception)))
        ;

        $logger = new Logger($innerLogger);
        ($executable)($logger, $exception);
    }
}
