<?php

declare(strict_types=1);

namespace SmartAssert\InvokableLoggingExceptionHandler;

use Psr\Log\LoggerInterface;

class Handler
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(\Throwable $exception): void
    {
        $this->logger->error((string) (new LoggableException($exception)));
    }
}
