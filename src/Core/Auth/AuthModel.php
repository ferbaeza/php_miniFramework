<?php

namespace Src\Core\Auth;

use Src\Core\Database\Model\Model;

class AuthModel extends Model
{
    public function id(): int|string
    {
        return $this->{$this->primaryKey};
    }

}
