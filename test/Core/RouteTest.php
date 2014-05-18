<?php

namespace Test\Core;
use PHPUnit_Framework_TestCase;
use Apolo\Core as Apolo;

class RouteTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Apolo\Route::map(array(), Apolo\Route::MODE_REPLACE);
    }

    public function testRetriveMap()
    {
        $this->assertEquals(array(), Apolo\Route::map());
        Apolo\Route::map(array('/' => 'Home'));
        $this->assertEquals(array('/' => 'Home'), Apolo\Route::map());
        Apolo\Route::map(array('/login' => 'Login'));
        $this->assertEquals(array('/' => 'Home', '/login' => 'Login'), Apolo\Route::map());
    }

}
