<?php

namespace Apolo\Core;
use DomainException;

class Apolo
{
    public function __construct()
    {
        throw new DomainException('You can\'t instanciate Apolo object');
    }
}
