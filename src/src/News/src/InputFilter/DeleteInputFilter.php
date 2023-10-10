<?php

declare(strict_types=1);

namespace News\InputFilter;

use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Uuid;

class DeleteInputFilter extends InputFilter
{
    // InputFilterPluginManager calls this init method in dependency injection process
    public function init()
    {
        // title
        $this->add(
            [
                'name'              => 'id',
                'required'          => true,
                'allow_empty'       => false,
                'validators'        => [
                    [
                        'name' => Uuid::class,
                    ],
                ],
                'filters'           => [],
                //'fallback_value'    => 1,
            ]
        );
    }
}
