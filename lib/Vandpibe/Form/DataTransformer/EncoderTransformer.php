<?php

/*
 * This file is part of the Vandpibe package.
 *
 * (c) Henrik Bjornskov <henrik@bjrnskov.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vandpibe\Form\DataTransformer;

use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class EncoderTransformer implements \Symfony\Component\Form\DataTransformerInterface
{
    /**
     * @var EncoderFactoryInterface
     */
    protected $factory;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @param EncoderFactoryInterface $factory
     * @param UserInterface           $user
     */
    public function __construct(EncoderFactoryInterface $factory, UserInterface $user)
    {
        $this->factory = $factory;
        $this->user = $user;
    }

    /**
     * @{inheritdoc}
     */
    public function transform($value)
    {
        // We only transform the value to the other site so always return the passed
        // $value
        return $value;
    }

    /**
     * @{inheritdoc}
     */
    public function reverseTransform($value)
    {
        // Only encode if $value holds something, empty means we shouldnt encode
        // anything at all.
        if (empty($value)) {
            return $value;
        }

        return $this->factory->getEncoder($this->user)->encodePassword($value, $this->user->getSalt());
    }
}
