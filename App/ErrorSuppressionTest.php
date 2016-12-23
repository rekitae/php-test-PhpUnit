<?php
use PHPUnit\Framework\TestCase;

class ErrorSuppressionTest extends TestCase
{
    public function testFileWriting1() {
        $writer = new FileWriter;
        $this->assertTrue(@$writer->write('writingFile.txt', 'stuff'));
    }

    public function testFileWriting2() {
        $writer = new FileWriter;
        $this->assertFalse(@$writer->write('/is-not-writeable/file', 'stuff'));
    }
}

class FileWriter
{
    public function write($file, $content) {
        $file = fopen($file, 'w');
        if($file == false) {
            return false;
        }
        fwrite($file, $content);

        return true;
    }
}
