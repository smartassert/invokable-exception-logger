<?php

declare(strict_types=1);

namespace SmartAssert\Tests\InvokableLoggingExceptionHandler;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use SmartAssert\InvokableLoggingExceptionHandler\Handler;
use SmartAssert\InvokableLoggingExceptionHandler\LoggableException;

class HandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testInvoke(): void
    {
        $exception = new \Exception('message', 99);

        $logger = \Mockery::mock(LoggerInterface::class);
        $logger
            ->shouldReceive('error')
            ->with((string) (new LoggableException($exception)))
        ;

        $handler = new Handler($logger);

        ($handler)($exception);
    }
}
