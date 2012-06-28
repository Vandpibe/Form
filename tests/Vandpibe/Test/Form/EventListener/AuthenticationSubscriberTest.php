<?php

namespace Vandpibe\Test\Form\EventListener;

use Vandpibe\Form\EventListener\AuthenticationSubscriber;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Form\FormEvents;

/**
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class AuthenticationSubscriberTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->event = $this->getMockBuilder('Symfony\Component\Form\Event\FilterDataEvent')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->session = $this->getMock('Symfony\Component\HttpFoundation\Session\SessionInterface');

        $this->subscriber = new AuthenticationSubscriber($this->session);
    }

    public function testOnFormSetData()
    {
        $exception = $this->getMockBuilder('Symfony\Component\Security\Core\Exception\AuthenticationException')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $form = $this->getMockBuilder('Symfony\Component\Form\Form')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $form
            ->expects($this->once())
            ->method('addError')
        ;

        $this->event
            ->expects($this->once())
            ->method('getForm')
            ->will($this->returnValue($form))
        ;

        $this->session
            ->expects($this->at(0))
            ->method('get')
            ->with($this->equalTo(SecurityContextInterface::AUTHENTICATION_ERROR))
            ->will($this->returnValue($exception))
        ;

        $this->session
            ->expects($this->at(1))
            ->method('remove')
            ->with($this->equalTo(SecurityContextInterface::AUTHENTICATION_ERROR))
        ;

        $this->session
            ->expects($this->at(2))
            ->method('get')
            ->with($this->equalTo(SecurityContextInterface::LAST_USERNAME))
            ->will($this->returnValue('my-username'))
        ;

        $this->event
            ->expects($this->once())
            ->method('setData')
            ->with($this->equalTo(array(
                '_username' => 'my-username',
            )))
        ;

        $this->subscriber->onFormSetData($this->event);

    }

    public function testSubscribedEvents()
    {
        $this->assertEquals(array(
            FormEvents::SET_DATA => 'onFormSetData',
        ), AuthenticationSubscriber::getSubscribedEvents());
    }
}
