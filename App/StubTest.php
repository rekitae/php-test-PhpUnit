<?php

use PHPUnit\Framework\TestCase;

class sampleClass
{
    public function func()
    {
        // do something;
        return 'foo';
    }
}

class StubTest extends TestCase
{
    public function testFunc()
    {
        $obj = new sampleClass;
        echo $obj->func(), PHP_EOL;
    }

    public function testMethodReturnNull()
    {
        $obj = $this->createMock(sampleClass::class);

        echo $obj->func(), ' < this is testStub will return null', PHP_EOL;
    }

    public function testCreateMock()
    {
        $obj = $this->createMock(sampleClass::class);

        $obj->method('func')
            ->will($this->returnValue('bar'));

        echo $obj->func(), PHP_EOL;
    }

    public function testGetMockBuilder()
    {
        $obj = $this->getMockBuilder('sampleClass')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $obj->method('func')
            ->will($this->returnValue('bar2'));

        echo $obj->func(), PHP_EOL;
    }

    public function testReturnArgumentStub()
    {
        $obj = $this->createMock(sampleClass::class);

        $obj->method('func')
            ->will($this->returnArgument(0));

        echo $obj->func('first'), PHP_EOL;
        echo $obj->func('second'), PHP_EOL;
    }

    public function testReturnValueMapStub1()
    {
        $obj = $this->createMock(sampleClass::class);

        $map = [
            ['1', '4', '5', '10'], // first + second + third = fourth
        ];

        $obj->method('func')
            ->will($this->returnValueMap($map));

        echo $obj->func('1','4','5'), PHP_EOL;
    }

    public function testReturnValueMapStub2()
    {
        $obj = $this->createMock(sampleClass::class);

        $map = [
            ['1', '2', '1'], // first > second return first
        ];

        $obj->method('func')
            ->will($this->returnValueMap($map));

        echo $obj->func('1','2'), PHP_EOL;
    }

    public function testReturnValueMapStub3()
    {
        $obj = $this->createMock(sampleClass::class);

        $map = [
            ['1', '2', '2'], // first > second return second
        ];

        $obj->method('func')
            ->will($this->returnValueMap($map));

        echo $obj->func('1','2'), PHP_EOL;
    }

    public function testReturnCallbackStub()
    {
        $obj = $this->createMock(sampleClass::class);

        $obj->method('func')
            ->will($this->returnCallback('customEncrypt'));

        echo $obj->func('test'), PHP_EOL;
    }

    public function testOnConsecutiveCallsStub()
    {
        $obj = $this->createMock(sampleClass::class);

        $obj->method('func')
            ->will($this->onConsecutiveCalls('first call', 'second call', 'third call'));

        echo '[', $obj->func(), ']'. PHP_EOL;
        echo '[', $obj->func(), ']'. PHP_EOL;
        echo '[', $obj->func(), ']'. PHP_EOL;
        echo '[', $obj->func(), ']'. PHP_EOL;
    }

    public function testThrowExceptionStub()
    {
        $obj = $this->createMock(sampleClass::class);

        $obj->method('func')
            ->will($this->throwException(new Exception('called throwException')));

        try {
            echo '[', $obj->func(), ']' . PHP_EOL;
        } catch (Exception $e) {
            echo 'catch exception', PHP_EOL;
        }
    }

    public function testObserversAreUpdated()
    {
/*
        $observer = $this->createMock(Observer::class);
        $observer->method('update')
            ->will($this->returnCallback('var_dump'));
*/

        $observer = $this->getMockBuilder(Observer::class)
            ->setMethods(['update'])
            ->getMock();

        $observer->expects($this->exactly(3))
            ->method('update')
            ->with(
                $this->anything(),
                $this->anything()
/*
                $this->greaterThan(0),
                $this->stringContains('Something'),
                $this->anything()
*/
            );

        $subject = new Subject('My subject');
        $subject->attach($observer);

        $subject->doSomething('----- 11111');
        $subject->doSomething('----- 22222');
        $subject->doSomething('----- 33333');
    }
    public function testOnceObserversAreUpdated()
    {
        $observer = $this->getMockBuilder(Observer::class)
            ->setMethods(['update'])
            ->getMock();

        $observer->expects($this->once())
            ->method('update')
            ->with($this->equalTo('something'));

        $subject = new Subject('My subject');
        $subject->attach($observer);

        $subject->doSomething('something');
    }

    public function testAnyObserversAreUpdated()
    {
        $observer = $this->getMockBuilder(Observer::class)
            ->setMethods(['update'])
            ->getMock();

        $observer->expects($this->Any())
            ->method('update')
            ->with($this->equalTo('something'));

        $subject = new Subject('My subject');
        $subject->attach($observer);

        $subject->doSomething('something');
        $subject->doSomething('something');
    }

    public function testNeverObserversAreUpdated()
    {
        $observer = $this->getMockBuilder(Observer::class)
            ->setMethods(['update'])
            ->getMock();

        $observer->expects($this->Never())
            ->method('update')
            ->with($this->equalTo('something'));

        $subject = new Subject('My subject');
        $subject->attach($observer);
    }
}

function customEncrypt($str)
{
    return str_rot13($str);
}

//////////////////////////////////////////////////

class Subject
{
    protected $observers = [];
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function attach(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    public function doSomething(string $str)
    {
        // Do something.
        // ...

        // Notify observers that we did something.
        $this->notify($str);
    }

    public function doSomethingBad()
    {
        foreach ($this->observers as $observer) {
            $observer->reportError(42, 'Something bad happened', $this);
        }
    }

    protected function notify($argument)
    {
        foreach ($this->observers as $observer) {
            $observer->update($argument, $argument . $argument);
        }
    }

    // Other methods.
}

class Observer
{
    public function update($argument, $argument2)
    {
        // Do something.
    }

    public function reportError($errorCode, $errorMessage, Subject $subject)
    {
        // Do something
    }

    // Other methods.
}
