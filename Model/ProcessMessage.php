<?php declare(strict_types=1);

namespace Vconnect\DelayedAmqpExample\Model;

use Psr\Log\LoggerInterface;

class ProcessMessage
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @param string $name
     * @param int $timestamp
     * @return void
     */
    public function execute(string $name, int $timestamp): void
    {
        $this->logger->info(sprintf(
            'Hello, %s! The message has been received. Delay: %u ms.',
            $name,
            floor(microtime(true) * 1000) - $timestamp
        ));
    }
}
