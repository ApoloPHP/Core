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
     * @expectedExceptionMessage You can't instanciate Apolo object
     */
    public function testCantInstanciate()
    {
        $apolo = new Apolo;
    }

    public function testSetAppDir()
    {
        $this->assertEquals(null, Apolo::appdir());
        $dir = __DIR__;
        Apolo::appdir($dir);
        $this->assertEquals($dir, Apolo::appdir());
    }

    public function testSysDir()
    {
        $dir = realpath(__DIR__ . '/../../');
        $this->assertEquals($dir, Apolo::sysdir());
    }

    /**
     * @covers \Apolo\Core\Apolo::setRoutes
     */
    public function testSetRoutes()
    {
        $routes1 = array('key' => 'value');
        $routes2 = array('name' => 'Michael');
        $routes3 = array('age' => 'simple');

        $this->assertEquals(array(), \Apolo\Core\Route::map());
        $this->assertEquals(null, Apolo::setRoutes(array()));

        Apolo::setRoutes($routes1);
        $this->assertEquals($routes1, \Apolo\Core\Route::map());

        Apolo::setRoutes($routes2);
        $this->assertEquals($routes2, \Apolo\Core\Route::map());

        Apolo::setRoutes($routes3, \Apolo\Core\Route::MODE_REPLACE);
        $this->assertEquals($routes3, \Apolo\Core\Route::map());

        Apolo::setRoutes($routes2, \Apolo\Core\Route::MODE_APPEND);
        $this->assertEquals($routes3 + $routes2, \Apolo\Core\Route::map());

        Apolo::setRoutes($routes1, \Apolo\Core\Route::MODE_PREPEND);
        $this->assertEquals($routes1 + $routes3 + $routes2, \Apolo\Core\Route::map());
    }
}
