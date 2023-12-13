<?php

namespace Src\Core\Exceptions;

use Src\Core\Exceptions\BaseException;
use Src\Core\Database\Exceptions\FillableModelException;

class BBDDBaseException extends BaseException
{
    protected static $messages = [
        FillableModelException::class => "Not fillable in this Model"
    ];
}
