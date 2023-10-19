<?php

namespace App\Form;

use App\Validator\PasswordHistory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\PasswordStrength;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPasswordCurrent', PasswordType::class,[
                'mapped' => false,
                'label' => 'Mot de passe actuel',
                'required' => false,
                'constraints' => new UserPassword([
                    'message' => 'Mot de passe actuel incorrect',
                ]),
                'attr' => [
                    'placeholder' => 'Mot de passe actuel'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ],
                'first_options' => [
                    'constraints' => [
                        new Assert\Regex([ 'pattern' => '/\d/', 'message' => 'Le mot de passe doit contenir au moins un chiffre.', ]),
                        new Assert\Regex([ 'pattern' => '/[A-Z]/', 'message' => 'Le mot de passe doit contenir au moins une lettre majuscule.', ]),
                        new Assert\Regex([ 'pattern' => '/[a-z]/', 'message' => 'Le mot de passe doit contenir au moins une lettre minuscule.', ]),
                        new Assert\Regex([ 'pattern' => '/[^A-Za-z0-9]/',]),
                        new NotBlank([
                            'message' => 'Saisissez un mot de passe',
                        ]),
                    ],
                    'label' => 'Nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Nouveau mot de passe',
                    ],
                    'label' => 'New password',
                ],
                'second_options' => [
                    'label' => 'Repeat Password',
                ],
                'invalid_message' => 'The password fields must match.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
