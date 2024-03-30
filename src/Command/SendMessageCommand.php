<?php

namespace App\Command;

use App\Constants\FormOptions;
use App\Entity\Channel;
use App\Entity\MessageHistory;
use App\Service\MessageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendMessageCommand extends Command
{
    protected static $defaultName = 'app:send-message';
    private $messageService;
    private $entityManager;

    public function __construct(MessageService $messageService, EntityManagerInterface $entityManager)
    {
        $this->messageService = $messageService;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Send a message to a contact via various channels')
            ->addArgument('channelId', InputArgument::REQUIRED, 'The channel ID to send the message')
            ->addArgument('type', InputArgument::REQUIRED, 'the type 0 for email, 1 for sms, 2  for webpush, 3 for telegeram, 4  for viber')
            ->addArgument('title', InputArgument::REQUIRED, 'The title of the message')
            ->addArgument('message', InputArgument::REQUIRED, 'The message to send');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $channelId = $input->getArgument('channelId');
        $type = $input->getArgument('type');
        $title = $input->getArgument('title');
        $message = $input->getArgument('message');
        $channel = $this->entityManager->getRepository(Channel::class)->find($channelId);

        if (!$channel) {
            $output->writeln('Error: Channel not found.');
            return Command::FAILURE;
        }

        if ($type < 0 || $type > 4) {
            $output->writeln('Error: type should be in range 0-4.');
            return Command::FAILURE;
        }

        $method = ucfirst(FormOptions::MESSAGE_OPTIONS[$type]);

        if (!$channel->getEnabled() || !$channel->{"get" . $method}()) {
            $output->writeln('Error: channel isnt enabled for this');
            return Command::FAILURE;
        }

        $messageHistory = new MessageHistory();
        $messageHistory->setType($type);
        $messageHistory->setChannel($channel);
        $messageHistory->setTitle($title);
        $messageHistory->setMessage($message);

        $this->entityManager->persist($messageHistory);
        $this->entityManager->flush();
        $this->messageService->send(
            $messageHistory->getChannel()->getCustomers(),
            FormOptions::MESSAGE_OPTIONS[$messageHistory->getType()],
            $messageHistory->getTitle(),
            $messageHistory->getMessage()
        );

        $output->writeln('Message sent successfully.');
        return Command::SUCCESS;
    }
}
