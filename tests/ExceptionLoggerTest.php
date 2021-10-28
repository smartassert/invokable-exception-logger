<?php

declare(strict_types=1);

namespace SmartAssert\Tests\InvokableLogger;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use SmartAssert\InvokableLogger\ExceptionLogger;
use SmartAssert\InvokableLogger\LoggableException;

class ExceptionLoggerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testInvoke(): void
    {
        $this->testExecute(function (ExceptionLogger $logger, \Throwable $exception) {
            ($logger)($exception);
        });
    }

    public function testLog(): void
    {
        $this->testExecute(function (ExceptionLogger $logger, \Throwable $exception) {
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

        $logger = new ExceptionLogger($innerLogger);
        ($executable)($logger, $exception);
    }
}
