<?php

use PHPUnit\Framework\TestCase;

require_once 'src/bootstrap.php';

class PassGeneratorTest extends TestCase
{
    public function testGenerate()
    {
        $passGenerator = new PassGenerator();
        $result = $passGenerator->generate();

        $this->assertIsString($result);
    }
}