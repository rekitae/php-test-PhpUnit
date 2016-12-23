<?php
use PHPUnit\Framework\TestCase;

class IncompleteAndSkippedTest extends TestCase
{
    private static $dbconn = null;

    public function test1()
    {
        $this->assertTrue(true);
        $this->markTestIncomplete('어설트 추가 해야함');
    }

    public function test2()
    {
        if (!self::$dbconn)
        {
            $this->markTestSkipped('디비 연결이 없어 테스트 스킵');
        }

        $this->assertTrue(false);
    }

    /**
     * @requires OS Linux
     */
    public function test3()
    {
        $this->assertTrue(true);
    }

    /**
     * @requires extension oci
     */
    public function test4()
    {
        $this->assertTrue(false);
    }
}