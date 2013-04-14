<?php

namespace Vandpibe\Test\Form\EventListener;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Exception\AuthenticationException; 
use Symfony\Component\Security\Core\SecurityContextInterface;
use Vandpibe\Form\EventListener\AuthenticationSubscriber;

/**
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class AuthenticationSubscriberTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->session = $this->mock('Symfony\Component\HttpFoundation\Session\SessionInterface');
        $this->subscriber = new AuthenticationSubscriber($this->session);
    }

    public function testOnFormSetData()
    {
        $exception = new AuthenticationException('Authentication Failed for reasons unknown to man.');

        $form = $this->mock('Symfony\Component\Form\Form');
        $form->shouldReceive('addError')->once()->withAnyArgs();

        $this->session->shouldReceive('get')->with(SecurityContextInterface::AUTHENTICATION_ERROR)->andReturn($exception);
        $this->session->shouldReceive('remove')->with(SecurityContextInterface::AUTHENTICATION_ERROR);
        $this->session->shouldReceive('get')->with(SecurityContextInterface::LAST_USERNAME)->andReturn('last-username');

        $event = $this->mock('Symfony\Component\Form\FormEvent');
        $event->shouldReceive('getForm')->once()->andReturn($form);
        $event->shouldReceive('setData')->once()->with(array(
            '_username' => 'last-username',
        ));

        $this->subscriber->onFormSetData($event);

    }

    public function testSubscribedEvents()
    {
        $this->assertEquals(array(
            FormEvents::PRE_SET_DATA => 'onFormSetData',
        ), AuthenticationSubscriber::getSubscribedEvents());
    }

    public function mock()
    {
        return call_user_func_array(array('Mockery', 'mock'), func_get_args());
    }
}
