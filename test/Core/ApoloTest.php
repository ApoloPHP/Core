<?php

namespace Test\Core;
use PHPUnit_Framework_TestCase;
use Apolo\Core\Apolo as Apolo;
use Apolo\Core\Route as Route;

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

    public function testSetRoutes()
    {
        $routes = array('key' => 'value');

        Route::map(array(), Route::MODE_REPLACE);

        $this->assertNull(Apolo::setRoutes($routes));
        $this->assertEquals($routes, Route::map());
    }
}
