<?php

declare(strict_types=1);

namespace News\InputFilter;

use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Between;
use Laminas\Validator\Digits;

class ListInputFilter extends InputFilter
{
    // InputFilterPluginManager calls this init method in dependency injection process
    public function init()
    {
        // Page
        $this->add(
            [
                'name'              => 'page',
                'required'          => true,
                'allow_empty'       => false,
                'validators'        => [
                    [
                        'name' => Digits::class,
                    ],
                    [
                        'name' => Between::class,
                        'options' => [
                            'min' => 1,
                            'max' => PHP_INT_MAX,
                            'inclusive' => true,
                        ],
                    ],
                ],
                'filters'           => [
                    [
                        'name' => ToInt::class,
                    ],
                ],
                //'fallback_value'    => 1,
            ]
        );

        // Limit
        $this->add(
            [
                'name'              => 'limit',
                'required'          => true,
                'allow_empty'       => false,
                'validators'        => [
                    [
                        'name' => Digits::class,
                    ],
                    [
                        'name' => Between::class,
                        'options' => [
                            'min' => 1,
                            'max' => 100,
                            'inclusive' => true,
                        ],
                    ],
                ],
                'filters'           => [
                    [
                        'name' => ToInt::class,
                    ],
                ],
                //'fallback_value'    => 10,
            ]
        );
    }
}
