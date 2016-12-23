<?php
use PHPUnit\Framework\TestCase;

class DataProviderIteratorTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testAdd($a)
    {
        //echo '------------- expected : ', $a, PHP_EOL;
        $this->assertEquals('firstelement', $a);
    }

    public function additionProvider()
    {
        $iter = new MyIterator();
        return $iter;
    }
}

class MyIterator implements Iterator {
    private $position = 0;
    private $array = array(
        "firstelement",
        "secondelement",
        "lastelement",
    );
    public function __construct() {
        $this->position = 0;
    }
    function rewind() {
        //var_dump(__METHOD__);
        $this->position = 0;
    }
    function current() {
        //var_dump(__METHOD__);
        //return ['A'];
        return [$this->array[$this->position]];
    }
    function key() {
        //var_dump(__METHOD__);
        return $this->position;
    }
    function next() {
        //var_dump(__METHOD__);
        ++$this->position;
    }
    function valid() {
        //var_dump(__METHOD__);
        return isset($this->array[$this->position]);
    }
}
