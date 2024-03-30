<?php

namespace App\Form;

use App\Constants\FormOptions;
use App\Entity\Channel;
use App\Entity\MessageHistory;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageHistoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('message', TextareaType::class)
            ->add('channel', EntityType::class, [
                'class' => Channel::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.enabled = :enabled')
                        ->setParameter('enabled', 1);
                },
                'choice_attr' => function($channel, $key, $index) {
                    return [
                        'data-email' => $channel->getEmail(),
                        'data-sms' => $channel->getSms(),
                        'data-webpush' => $channel->getWebpush(),
                        'data-telegram' => $channel->getTelegram(),
                        'data-viber' => $channel->getViber()
                    ];
                },
            ])
            ->add('type', ChoiceType::class, [
                'choices' => array_flip(FormOptions::MESSAGE_OPTIONS),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MessageHistory::class,
        ]);
    }
}
