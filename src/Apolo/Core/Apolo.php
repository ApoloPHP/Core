<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Apolo Framework
 *
 * It's a tiny framework that uses the Route/Method concept. All routes must 
 * be defined in bootstrap file.
 *
 * <code>
 * // bootstrap.php
 * Apolo\Apolo::setRoutes(array(
 *     '/'       => 'Controller\Welcome',
 *     '/login'  => 'Controller\Login',
 *     '/logout' => 'Controller\Logout',
 * ));
 * </code>
 *
 * MIT License
 * ===========
 *
 * Copyright (c) 2012 Michael <michaelgranados@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @category   Core
 * @package    Apolo
 * @subpackage Core
 * @author     Michael <michaelgranados@gmail.com>
 * @copyright  2012 Michael.
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    1.0.0
 * @link       http://github.com/ApoloPHP/Core
 */

namespace Apolo\Core;
use DomainException;

/**
 * Apolo framework
 * 
 * Just a litle framework that runs over routes mapped to controllers.
 *
 * This framework works in three basic steps:
 * - create routes
 * - create controller
 * - create a view
 *
 * The routes defines where all URLs in the project. Each URL need to be
 * redirected to an Controller. It is defined using
 * {@see Apolo\Apolo::setRoutes()}.
 *
 * The controller is a simple class. This class do not needs to extends any
 * other to work. Any method accessed represents the method in the controller.
 *
 * To be easy, the method is mapped with the same name inside the controller.
 * So if the user access a page via GET, Apolo will use the get method in the
 * controller and if the user sends a request inside a form that uses POST,
 * Apolo will use the post method of the controller.
 *
 * Here is a simple sample of a simple controller:
 *
 * <code>
 * class Hello
 * {
 *     public function get()
 *     {
 *         return  '&lt;form method="post">'
 *               . ' &lt;input type="text" name="name" />'
 *               . ' &lt;input type="submit" />'
 *               . '&lt;/form>';
 *     }
 *     public function post()
 *     {
 *         $name = filter_input(
 *             INPUT_POST, 'login', FILTER_SANITIZE_FULL_SPECIAL_CHARS
 *         );
 *         return 'Hello ' . $name;
 *     }
 * }
 * </code>
 *
 * @category  Core
 * @package   Apolo
 * @author    Michael Castillo <michaelgranados@gmail.com>
 * @copyright 2012 Michael Castillo
 * @license   http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version   GIT: <git_id>
 * @link      http://github.com/ApoloPHP/Core
 */
final class Apolo
{
    /**
     * Constructor, you can't use this method
     *
     * @throws \DomainException if you try to instanciate
     *
     * @return void
     */
    final public function __construct()
    {
        throw new DomainException('You can\'t instanciate Apolo object');
    }

    /**
     * The system directory
     *
     * @static
     *
     * @return string
     */
    public static function sysdir()
    {
        return realpath(dirname(__FILE__) . '/..');
    }

    /**
     * Sets and return the appdir
     *
     * The parameter is option, if setted it sets the directory of application.
     * In other hand, it returns the application dir.
     *
     * @param string $appdir (optional) Sets the application dir
     *
     * @return string
     * @static
     */
    public static function appdir($appdir = null)
    {
        static $_appdir;
        if (null !== $appdir && is_string($appdir)) {
            $_appdir = $appdir;
        }
        return $_appdir;
    }

    /**
     * Set new routes
     *
     * Set routes for redirect the user to any controller. You need to pass
     * the param of routes as array like this:
     *
     * <code>
     * $routes = array(
     *   'route' => 'Controller',
     * );
     * </code>
     *
     * All routes will be added to the actual routes and no one route setted
     * before will be replaced.
     *
     * You can pass a route like a regexp to especify a set of routes, like
     * this:
     *
     * <code>
     * $routes = array(
     *   'publish/\d+/?' => 'Publish',
     * );
     * </code>
     *
     * Here, you can use the replacer strings to use in your regexp, so the
     * development will be more intuictive.
     *
     * <code>
     * $routes = array(
     *   'see/:digit:/:slug:/?' => 'See',
     * );
     * </code>
     *
     * In the aboe sample, <kbd>:digit:</kbd> will be replaced by a
     * <kbd>[0-9]+</kbd> regexp. Here is the list of replacers:
     *
     * <pre>
     * - /              => \/
     * - :alpha:        => [a-zA-Z]+
     * - :alphanumeric: => [a-zA-Z0-9]+
     * - :digit:        => [0-9]+
     * - :slug:         => [a-zA-Z0-9_-]+
     * </pre>
     *
     * All elements in parentesis will be an argument to your controller like
     * this:
     *
     * <code>
     * $routes = array(
     *     '/edit/(article|image)/(:digit:)' => 'Edit',
     * //               arg1     ,  arg2
     * );
     * </code>
     *
     * So your controller will be something like this:
     *
     * <code>
     * class Edit
     * {
     *     function get($area, $id)
     *     {
     *         // your development
     *     }
     * }
     * </code>
     *
     * You can set 
     *
     * @param string[]  $routes Array of routes
     * @param string    $type   Type of insertion of routes
     *
     * @uses   \Apolo\Core\Route
     * @access public
     * @static
     * @return void
     */
    public static function setRoutes(
        array $routes, $type = Route::MODE_REPLACE
    ) {
        Route::map($routes, $type);
    }
}
