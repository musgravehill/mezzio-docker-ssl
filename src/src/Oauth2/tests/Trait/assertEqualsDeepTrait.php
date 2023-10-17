<?php

declare(strict_types=1);

namespace Oauth2\tests\Trait;

use PHPUnit\Framework\TestCase;

trait assertEqualsDeepTrait
{
    /**
     * @param object|array $expected
     * @param object|array $actual
     * @param string $message
     */
    public function assertEqualsDeep($expected, $actual, $message = '')
    {
        $expected = $this->hash($expected);
        $actual = $this->hash($actual);

        $this->assertSame($expected, $actual, $message);
    }

    /**
     * @param object|array $value
     * @return mixed
     */
    private function hash($value)
    {
        // serialize(), json_encode() ? 
        if (is_object($value)) {
            // array union vs array_merge()
            $value = ['__CLASS__' => get_class($value)] + get_object_vars($value);
        }
        if (is_array($value)) {
            /*
            @var callable $callback            
            function myCallback($n){ return compact($n);};  array_map('myCallback', [1,2]);
            $callback = function ($n) { // use ()
                return $n + 1;
            };
            // anonymous lambda closure
            $callback = static function ($n) { //not capture parent Scope (no $this inside)
                return $n + 1;
            };
            $callback = fn ($n) => $n + 1; //arrowFunc capture parent Scope
            $callback = static fn ($n) => $n + 1; //arrowFunc not capture parent Scope

            someClass::name with __invoke
            [someClass::name, 'staticFunction']
            [$obj, 'methodName']   

            $callable = $obj->methodName(...);
            $callable = someClass::staticFunction(...);

            $callable = \Closure::fromCallable('strtoupper'); // old way
            $callable = strtoupper(...); // first-class callable
            */

            $value = array_map([$this, __FUNCTION__], $value);
        }
        return $value;
    }
}
