<?php

/*
 * This file is part of the Vandpibe package.
 *
 * (c) Henrik Bjornskov <henrik@bjrnskov.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vandpibe\Test\Form\DependencyInjection;

use Vandpibe\Form\DependencyInjection\RemoveGuesserPass;

/**
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class RemoveGuesserPassTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->container = $this
            ->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->pass = new RemoveGuesserPass();
    }

    public function testProcessWhenDefinitionDosentExists()
    {
        $this->container
            ->expects($this->once())
            ->method('hasDefinition')
            ->with($this->equalTo('form.extension'))
            ->will($this->returnValue(false))
        ;

        $this->container
            ->expects($this->never())
            ->method('getDefinition')
        ;

        $this->pass->process($this->container);
    }

    public function testProcessReplaceArgumentWhenDefinitionExists()
    {
        $definition = $this->getMock('Symfony\Component\DependencyInjection\Definition');
        $definition
            ->expects($this->once())
            ->method('replaceArgument')
        ;

        $this->container
            ->expects($this->once())
            ->method('hasDefinition')
            ->will($this->returnValue(true))
        ;

        $this->container
            ->expects($this->once())
            ->method('getDefinition')
            ->will($this->returnValue($definition))
        ;

        $this->pass->process($this->container);
    }
}
