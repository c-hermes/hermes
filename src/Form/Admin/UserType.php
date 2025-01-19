<?php

namespace App\Form\Admin;

use App\Entity\Hermes\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active_newsletter', null, [
                'label' => 'global.active_newsletter',
            ])
            ->add('firstname', null, [
                'label' => 'user.firstname',
            ])
            ->add('lastname', null, [
                'label' => 'user.lastname',
            ])
            ->add('email', null, [
                'label' => 'user.email',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'user.password',
            ]);
            $builder
                ->add('roles', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
                    [
                        'multiple' => true,
                        'expanded' => true,
                        'choices' => $options['roles'],
                        'disabled' => $options['disable_roles']
                    ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'validation_groups' => function (FormInterface $form): array {
                $data = $form->getData();
                $roles = $data->getRoles();
                $password = $data->getPassword();
                if (in_array(User::ROLE_ADMIN, $roles) && '' == trim($password)){
                    return ['admin'];
                }
                return ['Default'];
            },
            'data_class' => User::class,
            'disable_roles' => false,
            'roles' => ['ROLE_USER'],
        ]);
    }
}
