<?php

namespace Vandpibe\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Vandpibe\Form\EventListener\AuthenticationSubscriber;

/**
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class AuthenticationType extends \Symfony\Component\Form\AbstractType
{
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', 'text')
            ->add('_password', 'password')
        ;

        if ($options['remember_me']) {
            $builder->add('_remember_me', 'checkbox');
        }

        $builder->addEventSubscriber(new AuthenticationSubscriber($this->session));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'remember_me' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return null;
    }
}
