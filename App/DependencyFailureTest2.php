<?php
use PHPUnit\Framework\TestCase;

class DependencyFailureTest2 extends TestCase
{
    public function testOne()
    {
        $this->assertTrue(false);
        return 1;
    }

    /**
     * @depends testOne
     */
    public function testTwo($num)
    {
        // run @depends annotation
        // @depends 가 성공하면 수행하고 아니면 skip 됨.
        $this->assertEquals(1, $num);
    }

    public function testThree()
    {
        $this->assertTrue(true);
    }

    public function testFour()
    {
        $this->assertTrue(true);
    }

    public function testFive()
    {
        // skip
    }
}
