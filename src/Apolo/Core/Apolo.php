<?php

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
