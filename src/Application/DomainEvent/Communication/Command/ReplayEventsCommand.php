<?php

declare(strict_types = 1);

namespace App\Application\DomainEvent\Communication\Command;

use App\Application\DomainEvent\Business\EventsManager\EventsManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ReplayEventsCommand extends Command
{
    public function __construct(private readonly EventsManagerInterface $eventsManager)
    {
        parent::__construct(null);
    }

    protected function configure()
    {
        $this
            ->setName('events:replay')
            ->setDescription('Send all to exchange')
            ->setHelp('Replay all events from log file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->eventsManager->replay();

        return self::SUCCESS;
    }
}
