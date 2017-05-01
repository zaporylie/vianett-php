<?php

namespace zaporylie\Vianett\Test\Unit;

use zaporylie\Vianett\Exception;

class ExceptionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests Vianett generic exception.
     */
    public function testException()
    {
        $exception = new Exception('message', 1);
        $this->assertEquals('message', $exception->getMessage());
        $this->assertEquals(1, $exception->getCode());
    }
}
