<?php

namespace Src\Core\Database\Migrations\Interface;

interface MigrationInterface
{
    public function up();
    public function down();
}
