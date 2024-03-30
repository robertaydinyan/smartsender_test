<?php

namespace App\EventListener;

use App\Constants\FormOptions;
use App\Event\CustomerRegisteredEvent;
use App\Service\MessageService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SendWelcomeMessageListener implements EventSubscriberInterface
{

    private $messageSender;

    public function __construct(MessageService $messageSender)
    {
        $this->messageSender = $messageSender;
    }

    public static function getSubscribedEvents()
    {
        return [
            CustomerRegisteredEvent::NAME => 'onCustomerRegistered',
        ];
    }

    public function __invoke(CustomerRegisteredEvent $event)
    {
        $customer = $event->getCustomer();
        $this->messageSender->send(array($customer), FormOptions::MESSAGE_OPTIONS[1], 'Welcome', 'Welcome to our platform!');
    }
}
