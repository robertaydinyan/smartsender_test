<?php

namespace App\Form;

use App\Entity\Channel;
use App\Entity\Customer;
use App\EventSubscriber\CheckboxDefaultValueSubscriber;
use App\Form\DataTransformer\IntegerToBooleanTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChannelType extends AbstractType
{
    private $transformer;

    public function __construct(IntegerToBooleanTransformer $transformer)
    {
        $this->transformer = $transformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('enabled', CheckboxType::class, [
                'required' => false
            ])
            ->add('email', CheckboxType::class, [
                'required' => false
            ])
            ->add('sms', CheckboxType::class, [
                'required' => false
            ])
            ->add('webpush', CheckboxType::class, [
                'required' => false
            ])
            ->add('telegram', CheckboxType::class, [
                'required' => false
            ])
            ->add('viber', CheckboxType::class, [
                'required' => false
            ])
            ->add('channelCustomers', EntityType::class, [
                'class' => Customer::class,
                'choice_label' => 'name',
                'multiple' => true,
            ]);

        $builder->addEventSubscriber(new CheckboxDefaultValueSubscriber());
        $builder->get('enabled')->addModelTransformer($this->transformer);
        $builder->get('email')->addModelTransformer($this->transformer);
        $builder->get('sms')->addModelTransformer($this->transformer);
        $builder->get('webpush')->addModelTransformer($this->transformer);
        $builder->get('telegram')->addModelTransformer($this->transformer);
        $builder->get('viber')->addModelTransformer($this->transformer);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Channel::class,
        ]);
    }
}
