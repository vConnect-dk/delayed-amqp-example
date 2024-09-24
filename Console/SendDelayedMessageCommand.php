<?php declare(strict_types=1);

namespace Vconnect\DelayedAmqpExample\Console;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Vconnect\DelayedAmqp\MessageQueue\DelayedPublisher;

class SendDelayedMessageCommand extends Command
{
    public function __construct(
        private readonly DelayedPublisher $delayedPublisher,
        private readonly LoggerInterface $logger,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('delayed-message:send')
            ->setDescription('Send Delayed Message')
            ->addArgument(
                name: 'name',
                mode: InputArgument::OPTIONAL,
                default: 'Anonymous'
            )->addOption(
                name: 'delay',
                shortcut: 'd',
                mode: InputOption::VALUE_OPTIONAL,
                default: 10000
            );

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $message = sprintf('Message for %s has been dispatched.', $name);

        $this->delayedPublisher->publish(
            'vconnect.delayed.example',
            ['name' => $name, 'timestamp' => (int)floor(microtime(true) * 1000)],
            (int)$input->getOption('delay')
        );
        $this->logger->info($message);
        $output->writeln($message);

        return self::SUCCESS;
    }
}
