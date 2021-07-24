<?php

namespace App\Form;

use App\Entity\Donation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('donor', null, [
                "attr" => [
                    "class" => "select2"
                ]
            ])
            ->add('recipient', null, [
                "attr" => [
                    "class" => "select2"
                ]
            ])
            ->add('donationCenter')



            ->add('donorStatus', ChoiceType::class, [
                "choices" => [
                    "good" => "good",
                    "bad" => "bad",
                    "acute" => "acute",
                    "not unknown" => "not unknown",
                ]
            ])
            ->add('recipientStatus', ChoiceType::class, [
                "choices" => [
                    "good" => "good",
                    "bad" => "bad",
                    "not unknown" => "not unknown",
                ]
            ])
            ->add('processedAt');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Donation::class,
        ]);
    }
}
