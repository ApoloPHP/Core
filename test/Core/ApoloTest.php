<?php

namespace Test\Core;
use PHPUnit_Framework_TestCase;
use Apolo\Core\Apolo as Apolo;

class ApoloTest extends PHPUnit_Framework_TestCase
{
    public $apolo = null;

    public function testInstace()
    {
        $this->assertTrue(class_exists('Apolo\\Core\\Apolo'));
    }

    /**
     * @expectedException DomainException
     */
    public function testCantInstanciate()
    {
        $apolo = new Apolo;
    }
}
