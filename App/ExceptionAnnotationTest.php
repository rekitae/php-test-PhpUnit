<?php
use PHPUnit\Framework\TestCase;

class ExceptionAnnotationTest extends TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testException1()
    {
        //echo '1 ------------------- ', PHP_EOL;
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testException2()
    {
        throw new InvalidArgumentException();
        //echo '2 ------------------- ', PHP_EOL;
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testException3()
    {
        //echo '3 ------------------- ', PHP_EOL;
        throw new InvalidArgumentException();
    }
}
