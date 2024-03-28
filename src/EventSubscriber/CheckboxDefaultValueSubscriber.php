<?php
namespace App\EventSubscriber;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ReflectionClass;
use ReflectionProperty;

class CheckboxDefaultValueSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::SUBMIT => 'setDefaultValues',
        ];
    }

    public function setDefaultValues(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $reflectionClass = new ReflectionClass($data);
        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $property->setAccessible(true); // Bypass visibility restriction
            if (!$property->isStatic()) {
                if (!$property->isInitialized($data)) {
                    $property->setValue($data, 0);
                }
            }
        }

        $event->setData($data);
    }
}
