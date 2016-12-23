<?php
use PHPUnit\Framework\TestCase;

class DependencyTest extends TestCase
{
    private $arr;

    public function setUp()
    {
        echo 'setUp' , PHP_EOL;

        // 개별 테스트케이스 마다 셋업을 수행 (테스트케이스 숫자 만큼 수행됨)
        $this->arr = [1];
    }

    public function tearDown()
    {
        echo 'tearDown' , PHP_EOL;
    }

    public function testEmpty()
    {
        $this->assertNotEmpty($this->arr);
    }

    public function testAddSomething()
    {
        array_push($this->arr, 2);
        array_push($this->arr, 3);

        $this->assertEquals([1,2,3], $this->arr);

        return 'A';
    }

    public function testAddSomething2()
    {
        array_push($this->arr, 3);

        $this->assertEquals([1,3], $this->arr);

        return 'B';
    }

    public function testAddSomething3()
    {
        return ['B','C'];
    }

    /**
     * @depends testAddSomething
     * @depends testAddSomething2
     * @depends testAddSomething3
     */
    public function testCheckSomething()
    {
        $this->assertEquals(
            ['A', 'B',['B','C']],
            func_get_args()
        );
    }
}
