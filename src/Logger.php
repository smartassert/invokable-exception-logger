<?php

declare(strict_types=1);

namespace SmartAssert\InvokableLogger;

use Psr\Log\LoggerInterface;

class Logger
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(\Throwable $exception): void
    {
        $this->log($exception);
    }

    public function log(\Throwable $exception): void
    {
        $this->logger->error((string) (new LoggableException($exception)));
    }
}
