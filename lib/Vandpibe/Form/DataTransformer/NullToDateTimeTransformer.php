<?php

namespace Vandpibe\Form\DataTransformer;

/**
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class NullToDateTimeTransformer implements \Symfony\Component\Form\DataTransformerInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function transform($value)
    {
        return $value;
    }

    /**
     * @param mixed $value
     * @return mixed|DateTime
     */
    public function reverseTransform($value)
    {
        return $value === null ? new \DateTime() : $value;
    }
}
