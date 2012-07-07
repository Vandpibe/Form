<?php

namespace Vandpibe\Form\Extension;

use Symfony\Component\Form\FormBuilderInterface;
use Vandpibe\Form\DataTransformer\NullToDateTimeTransformer;

/**
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class DateTypeExtension extends \Symfony\Component\Form\AbstractTypeExtension
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new NullToDateTimeTransformer());
    }

    /**
     * @return string
     */
    public function getExtendedType()
    {
        return 'date';
    }
}
