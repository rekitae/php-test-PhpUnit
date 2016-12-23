<?php
use PHPUnit\Framework\TestCase;

class MagicMethodAndSharingFixtureTest extends TestCase
{
    private static $dbconn = 'null';

    public static function setUpBeforeClass()
    {
        self::$dbconn = 'connected';
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    protected function setUp()
    {
        fwrite(STDOUT, __METHOD__ . ' ['.self::$dbconn. "]\n");
    }

    public function tearDown()
    {
        fwrite(STDOUT, __METHOD__ . ' ['.self::$dbconn. "]\n");
    }

    public static function tearDownAfterClass()
    {
        self::$dbconn = 'disconnected';
        fwrite(STDOUT, __METHOD__ . ' ['.self::$dbconn. "]\n");
    }

    protected function assertPreConditions()
    {
        fwrite(STDOUT, __METHOD__ . ' ['.self::$dbconn. "]\n");
    }

    protected function assertPostConditions()
    {
        fwrite(STDOUT, __METHOD__ . ' ['.self::$dbconn. "]\n");
    }

    protected function onNotSuccessfulTest($e)
    {
        fwrite(STDOUT, __METHOD__ . ' ['.self::$dbconn. "]\n");
    }

    public function test1()
    {
        $this->assertEquals(1, 1);
        $this->assertTrue(true);
    }

    public function test2()
    {
        // failure 를 onNotSuccessfulTest 가 가로챔
        $this->assertFalse(true);
    }
}
