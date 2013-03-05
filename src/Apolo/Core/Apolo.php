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
use DomainException;

class Apolo
{
    /**
     * Constructor, you can't use this method
     *
     * @return void
     */
    final public function __construct()
    {
        throw new DomainException('You can\'t instanciate Apolo object');
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
}
