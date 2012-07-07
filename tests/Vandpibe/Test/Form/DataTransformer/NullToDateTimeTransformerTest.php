<?php

namespace Vandpibe\Test\Form\DataTransformer;

use Vandpibe\Form\DataTransformer\NullToDateTimeTransformer;

/**
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class NullToDateTimeTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->transformer = new NullToDateTimeTransformer();
    }

    public function testTransform()
    {
        $this->assertEquals('something', $this->transformer->transform('something'));
    }

    public function testReverseTransform()
    {
        $this->assertInstanceOf('DateTime', $this->transformer->reverseTransform(null));
        $this->assertEquals('NotNull', $this->transformer->reverseTransform('NotNull'));
        $this->assertEquals('', $this->transformer->reverseTransform(''));
        $this->assertFalse($this->transformer->reverseTransform(false));
    }
}
