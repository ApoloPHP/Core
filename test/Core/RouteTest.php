<?php

namespace Test\Core;
use PHPUnit_Framework_TestCase;
use Apolo\Core\Route as Route;

class RouteTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Route::map(array(), Route::MODE_REPLACE);
    }

    public function testRetriveMap()
    {
        $this->assertEquals(array(), Route::map());
        Route::map(array('/' => 'Home'));
        $this->assertEquals(array('/' => 'Home'), Route::map());
        Route::map(array('/login' => 'Login'));
        $this->assertEquals(array('/' => 'Home', '/login' => 'Login'), Route::map());
    }

    public function testDefaultAppendData()
    {
        Route::map(array('/' => 'Home'));
        Route::map(array('/login' => 'Login'));
        Route::map(array('/logout' => 'Logout'));
        $this->assertEquals(array('/' => 'Home', '/login' => 'Login', '/logout' => 'Logout'), Route::map());
    }

    public function testSpecifyAppendData()
    {
        Route::map(array('/' => 'Home'), Route::MODE_APPEND);
        Route::map(array('/login' => 'Login'), Route::MODE_APPEND);
        Route::map(array('/logout' => 'Logout'), Route::MODE_APPEND);
        $this->assertEquals(array('/' => 'Home', '/login' => 'Login', '/logout' => 'Logout'), Route::map());
    }

    public function testSpecifyPrependData()
    {
        Route::map(array('/' => 'Home'), Route::MODE_PREPEND);
        Route::map(array('/login' => 'Login'), Route::MODE_PREPEND);
        Route::map(array('/logout' => 'Logout'), Route::MODE_PREPEND);
        $this->assertEquals(array('/logout' => 'Logout', '/login' => 'Login', '/' => 'Home'), Route::map());
    }

    public function testSpecifyReplaceData()
    {
        Route::map(array('/' => 'Home'), Route::MODE_REPLACE);
        Route::map(array('/login' => 'Login'), Route::MODE_REPLACE);
        Route::map(array('/logout' => 'Logout'), Route::MODE_REPLACE);
        $this->assertEquals(array('/logout' => 'Logout'), Route::map());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSpecifyInvalidMode()
    {
        Route::map(array('/' => 'Home'), 'bla');
    }

    public function testProcessedRoutes()
    {
        Route::map(array(
            '/'                  => 'Home',
            '/article/(:digit:)' => 'Article',
            '/post/(:slug:)'     => 'Post',
        ), Route::MODE_REPLACE);
        $expected = array(
            '^\/$'                       => 'Home',
            '^\/article\/([0-9]+)$'      => 'Article',
            '^\/post\/([a-zA-Z0-9_-]+)$' => 'Post',
        );
        $this->assertEquals($expected, Route::processedRoutes());
    }

    public function testRegexReplaceEmptyString()
    {
        $this->assertEquals('^$', Route::convert2regex(''));
    }

    public function testRegexEscapeSlashes()
    {
        $this->assertEquals('^\/method\/action$', Route::convert2regex('/method/action'));
    }

    public function testRegexChangeSnippets()
    {
        $this->assertEquals('^action-[0-9]+$', Route::convert2regex('action-:digit:'));
        $this->assertEquals('^process_[a-zA-Z]+$', Route::convert2regex('process_:alpha:'));
        $this->assertEquals('^ticket-[a-zA-Z0-9]+$', Route::convert2regex('ticket-:alphanumeric:'));
        $this->assertEquals('^article-[a-zA-Z0-9_-]+$', Route::convert2regex('article-:slug:'));
    }

    public function testRegexChangeMultipleSnippets()
    {
        $this->assertEquals('^\/article\/([a-zA-Z0-9_-]+)\/?$', Route::convert2regex('/article/(:slug:)/?'));
    }
}
