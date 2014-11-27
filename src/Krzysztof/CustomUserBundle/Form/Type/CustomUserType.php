<?php
namespace Krzysztof\CustomUserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CustomUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       // $builder->setData($options['data']['user']);
        $builder
            ->add('username', 'text')
            ->add('password', 'repeated', array(
                'type' => 'password',
                'first_name' => 'password',
                'second_name' => 'confirm',
                ))
            ->add('Register', 'submit')
            ->add('user_id', 'hidden')
            ->add('type_access', 'hidden')
            ->add('active', 'hidden')
            ->add('_token', 'hidden')
        ;
    }

    public function getName()
    {
        return 'CustomUserType';
    }
}