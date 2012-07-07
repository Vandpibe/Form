<?php

namespace Vandpibe\Test\Form\Extension;

use Mockery;
use Vandpibe\Form\Extension\DateTypeExtension;

/**
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class DateTypeExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->extension = new DateTypeExtension();
    }

    public function testBuildForm()
    {
        $builder = Mockery::mock('Symfony\Component\Form\FormBuilder');
        $builder->shouldReceive('addModelTransformer')->once()->with(Mockery::type('Vandpibe\Form\DataTransformer\NullToDateTimeTransformer'));

        $this->extension->buildForm($builder, array());

    }

    public function testGetExtendedType()
    {
        $this->assertEquals('date', $this->extension->getExtendedType());
    }
}
