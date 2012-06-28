<?php

namespace Vandpibe\Test\Form\Type;

use Vandpibe\Form\Type\AuthenticationType;

/**
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class AuthenticationTypeTest extends \Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->session = $this->getMock('Symfony\Component\HttpFoundation\Session\SessionInterface');
        $this->type = new AuthenticationType($this->session);
    }

    public function testBuildForm()
    {
        $form = $this->factory->create($this->type);

        $this->assertTrue($form->has('_username'));
        $this->assertTrue($form->has('_password'));
        $this->assertTrue($form->has('_remember_me'));

        $form = $this->factory->create($this->type, null, array(
            'remember_me' => false,
        ));

        $this->assertFalse($form->has('_remember_me'));
    }
}
