<?php
/**
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
use InvalidArgumentException;
use Apolo\Core\Request as Request;

/**
 * Route Object
 * 
 * @category   Core
 * @package    Apolo
 * @subpackage Core
 * @author     Michael <michaelgranados@gmail.com>
 * @link       http://github.com/dgmike/apolo
 **/
class Route
{
    const MODE_APPEND  = 'append';
    const MODE_PREPEND = 'prepend';
    const MODE_REPLACE = 'replace';

    protected static $conversors = array(
        '/'              => '\/',
        ':alpha:'        => '[a-zA-Z]+',
        ':alphanumeric:' => '[a-zA-Z0-9]+',
        ':digit:'        => '[0-9]+',
        ':slug:'         => '[a-zA-Z0-9_-]+',
        ':ext:'          => '\.([a-zA-Z0-9~_-]{2,5})',
    );

    public static function map($routes = null, $mode = self::MODE_APPEND)
    {
        static $_routes;

        if (!in_array(strtolower(gettype($routes)), array('array', 'null'))) {
            throw new InvalidArgumentException();
        }
        if (!$_routes) {
            $_routes = array();
        }
        if ($routes === null) {
            return $_routes;
        }
        if ($mode === self::MODE_APPEND) {
            foreach ($routes as $key => $value) {
                $_routes[$key] = $value;
            }
        } elseif ($mode === self::MODE_PREPEND) {
            $_routes = array_reverse($_routes);
            foreach ($routes as $key => $value) {
                $_routes[$key] = $value;
            }
            $_routes = array_reverse($_routes);
        } else {
            $_routes = $routes;
        }
    }
}
