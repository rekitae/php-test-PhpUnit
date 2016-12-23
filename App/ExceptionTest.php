<?php
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    public function dataProvider()
    {
        return [
            [1],
            [2],
            [3],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testException($a)
    {
       // echo '1 ------------------- ', $a, PHP_EOL;

        $this->expectException(InvalidArgumentException::class);

        if (!in_array($a, [3, 4, 5])) {
            // $a 가 1,2 일때 throw
            throw new InvalidArgumentException();
        }


        //echo '1 --------- ' , $a , PHP_EOL;
    }

    public function testSeparator()
    {
        //echo '------------------------------------' , PHP_EOL;
    }

    /**
     * @dataProvider dataProvider
     */
    public function testException2($a)
    {
        //echo '2 ------------------- ', $a, PHP_EOL;

        $this->expectException(InvalidArgumentException::class);

        if (!in_array($a, [4, 5, 6])) {
            // $a 가 1,2,3 일때 즉 모두 throw
            throw new InvalidArgumentException();
        }

        // do not reach
        //echo '2 --------- ' , $a , PHP_EOL;
    }

    public function testSeparator2()
    {
        //echo '------------------------------------' , PHP_EOL;
    }

    /**
     * @dataProvider dataProvider
     */
    public function testException3($a)
    {
        //echo '3 ------------------- ', $a, PHP_EOL;

        $this->expectException(InvalidArgumentException::class);

        if (!in_array($a, [1, 2, 3])) {
            // do not reach this block
            throw new InvalidArgumentException();
        }

        //echo '3 --------- ' , $a , PHP_EOL;
    }
}
