<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Apolo Framework
 *
 * It's a tiny framework that uses the Route/Method concept. All routes must
 * be defined in bootstrap file.
 *
 * ```php
 * // bootstrap.php
 * Apolo\Core\Apolo::setRoutes(array(
 *     '/'       => 'Controller\Welcome',
 *     '/login'  => 'Controller\Login',
 *     '/logout' => 'Controller\Logout',
 * ));
 * ```
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
 * `{@see Apolo\Apolo::setRoutes()}`.
 *
 * The controller is a simple class. This class do not needs to extends any
 * other to work. Any method accessed represents the method in the controller.
 *
 * To be easy, the method is mapped with the same name inside the controller.
 * So if the user access a page via `GET`, Apolo will use the get method in the
 * controller, otherwise if the client sends a request using `POST`,
 * Apolo will use the post method of the controller.
 *
 * Here is a simple sample of a simple controller:
 *
 * ```php
 * class Hello
 * {
 *     public function get()
 *     {
 *         return  '<form method="post">'
 *               . ' <input type="text" name="name" />'
 *               . ' <input type="submit" />'
 *               . '</form>';
 *     }
 *     public function post()
 *     {
 *         $name = filter_input(
 *             INPUT_POST, 'login', FILTER_SANITIZE_FULL_SPECIAL_CHARS
 *         );
 *         return 'Hello ' . $name;
 *     }
 * }
 * ```
 *
 * @category  Core
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
     * @internal
     * @public
     * @throws \DomainException if you try to instanciate
     * @return void
     */
    final public function __construct()
    {
        throw new DomainException('You can\'t instanciate Apolo object');
    }

    /**
     * The system directory
     *
     * This method is usefull to internal load/reference another files.
     *
     * ```php
     * $route_file = Apolo\Core\Apolo::sysdir() . '/src/Route.php';
     * ```
     *
     * @internal
     * @public
     * @static
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
     * ```php
     * Apolo::appdir(__DIR__ . '/app');
     * $controller_file = Apolo::appdir() . 'Controller\PostController.php';
     * ```
     *
     * @param null|string $appdir Sets the application dir
     *
     * @public
     * @static
     * @return string
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
     * ```php
     * $routes = array(
     *   'route' => 'Controller',
     * );
     * ```
     *
     * All routes will be added to the actual routes and no one route setted
     * before will be replaced.
     *
     * You can pass a route like a regexp to especify a set of routes, like
     * this:
     *
     * ```php
     * $routes = array(
     *   'publish/\d+/?' => 'Publish',
     * );
     * ```
     *
     * Here, you can use the replacer strings to use in your regexp, so the
     * development will be more intuictive.
     *
     * ```php
     * $routes = array(
     *   'see/:digit:/:slug:/?' => 'See',
     * );
     * ```
     *
     * In the aboe sample, <kbd>:digit:</kbd> will be replaced by a <kbd>[0-9]+</kbd>
     * regexp. Here is the list of replacers:
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
     * ```php
     * $routes = array(
     *     '/edit/(article|image)/(:digit:)' => 'Edit',
     * //               arg1     ,  arg2
     * );
     * ```
     *
     * So your controller will be something like this:
     *
     * ```php
     * class Edit
     * {
     *     function get($area, $id)
     *     {
     *         // your development
     *     }
     * }
     * ```
     *
     * @param string[]  $routes Array of routes
     * @param string    $mode   Type of insertion of routes
     *
     * @uses \Apolo\Core\Route
     * @public
     * @static
     * @return void
     */
    public static function setRoutes(
        array $routes, $mode = Route::MODE_REPLACE
    ) {
        Route::map($routes, $mode);
    }

    /**
     * Discovers className to process route
     *
     * Use this method in combination with `{@see \Apolo\SetRoutes}` method to
     * process the route and use the right controller.
     *
     * ```php
     * Apolo::setRoutes(array(
     *     '/show/post/(:digit:)' => 'PostEditController',
     * ));
     *
     * Apolo::discover('/show/post/25'); // -> PostEditController
     * ```
     *
     * @param string $uri Url to convert to controller ClassName
     *
     * @uses \Apolo\Core\Route
     * @internal
     * @public
     * @static
     * @return string
     */
    public static function discover($uri)
    {
        $routes = Route::processedRoutes();
        foreach ($routes as $regex => $className) {
            if (preg_match("/$regex/", $uri)) {
                return $className;
            }
        }
    }

    /**
     * Process and return method to be used in controller
     *
     * @param array $request Pass the $_REQUEST array as dependency
     *
     * @internal
     * @static
     * @public
     * @return string
     */
    public static function method(array $request = array())
    {
        if (!array_key_exists('REQUEST_METHOD', $request)) {
            return 'get';
        }
        if (strtoupper($request['REQUEST_METHOD']) === 'POST') {
            if (array_key_exists('_method', $_POST) && is_string($_POST['_method'])) {
                return strtolower($_POST['_method']);
            }
            return 'post';
        }
        return strtolower($request['REQUEST_METHOD']);
    }
}
