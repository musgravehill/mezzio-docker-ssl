<?php

declare(strict_types=1);

namespace News\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\StringLength;

class CreateInputFilter extends InputFilter
{
    // InputFilterPluginManager calls this init method in dependency injection process
    public function init()
    {
        // title
        $this->add(
            [
                'name'              => 'title',
                'required'          => true,
                'allow_empty'       => false,
                'validators'        => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 3,
                            'max' => 255,
                            'encoding' => 'UTF-8', //utf8mb4 is just MariaDB nickname for utf8                        
                        ],
                    ],
                ],
                'filters'           => [
                    [
                        'name' => StringTrim::class,
                    ],
                    [
                        'name' => StripTags::class,
                        'options' => [
                            //'allowTags'     => 'Tags which are allowed',
                            //'allowAttribs'  => 'Attributes which are allowed',
                            //'allowComments' => 'Are comments allowed ?',
                        ],
                    ],
                ],
                //'fallback_value'    => 1,
            ]
        );

        // text
        $this->add(
            [
                'name'              => 'text',
                'required'          => true,
                'allow_empty'       => false,
                'validators'        => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 3,
                            'max' => 65535,
                            'encoding' => 'UTF-8', //utf8mb4 is just MariaDB nickname for utf8                        
                        ],
                    ],
                ],
                'filters'           => [
                    [
                        'name' => StringTrim::class,
                    ],
                ],
                //'fallback_value'    => 1,
            ]
        );
    }
}
