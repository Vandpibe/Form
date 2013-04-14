<?php

namespace Vandpibe\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class AuthenticationSubscriber implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
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
     * @param FormEvent $event
     */
    public function onFormSetData(FormEvent $event)
    {
        $error = $this->session->get(SecurityContextInterface::AUTHENTICATION_ERROR);

        // Remove error so it isnt persisted
        $this->session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);

        if ($error) {
            $event->getForm()->addError(new FormError($error->getMessage()));
        }

        $event->setData(array(
            '_username' => $this->session->get(SecurityContextInterface::LAST_USERNAME),
        ));
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'onFormSetData',
        );
    }
}
