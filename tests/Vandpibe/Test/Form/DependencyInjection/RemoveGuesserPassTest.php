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
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class RemoveGuesserPassTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->pass = new RemoveGuesserPass();
    }

    public function testProcessWhenDefinitionDosentExists()
    {
        $this->pass->process($this->container);
    }

    public function testProcessReplaceArgumentWhenDefinitionExists()
    {
        $this->container->setDefinition('form.extension', new Definition(null, [
            null,
            [],
            [],
            [
                'form.guesser.random',
            ]
        ]));

        $this->pass->process($this->container);

        $definition = $this->container->getDefinition('form.extension');

        $this->assertCount(0, $definition->getArgument(3));
    }
}
