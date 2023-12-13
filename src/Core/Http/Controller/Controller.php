<?php

namespace Src\Core\Http\Controller;

use Src\Core\Http\Request\Request;

/**
 * Undocumented class
 */

class Controller
{
    public function __call($name, $arguments)
    {
        if (property_exists($this, $name)) {

            return call_user_func_array([$this->$name, '__invoke'], $arguments);
        }
    }
}
