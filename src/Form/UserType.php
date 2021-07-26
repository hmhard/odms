<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $role = ["System Admin" => "ROLE_SYSTEM_ADMIN", "Doctor" => "ROLE_DOCTOR", "Recipient" => "ROLE_RECEPIENT", "Donor" => "ROLE_DONOR"];

        $builder

            ->add('roles', ChoiceType::class, ["choices" => $role, 'mapped' => false, "multiple" => true, "placeholder" => "Select Role"])

            ->add('email', EmailType::class)
            ->add('firstName')
            ->add('lastName')
            ->add('middleName')
            ->add('userType')
            ->add('sex', ChoiceType::class, ["choices" => ["Male" => "Male", "Female" => "Female"], "placeholder" => "Select Sex"])
            ->add('phone')
            ->add('birthDate')
         

         
  
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
