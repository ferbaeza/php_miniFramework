<?php

namespace App\database\migrations;

use Src\Core\Facades\Schema;
use Src\Core\Database\Migrations\Interface\MigrationInterface;

/**
 * @method table() //*mandatory get the instance of the DataBaseBuilder with the table name
 * @method uuid($column = 'id')
 * @method string($column = 'string' , $length = '255', $default = false)
 * @method integer($column = 'number' , $length = '4', $default = false)
 * @method bigInteger($column = 'number' , $length = '8', $default = false)
 * @method tinyInteger($column = 'number' , $length = '1', $default = false)
 * @method smallInteger($column = 'number' , $length = '2', $default = false)
 * @method mediumInteger($column = 'number' , $length = '3', $default = false)
 * @method decimal($column = 'number' , $length = '8', $default = false)
 * @method float($column = 'number' , $length = '4', $default = false)
 * @method double($column = 'number' , $length = '8', $default = false)
 * @method boolean($column = 'number' , $default = false)
 * @method text($column = 'text')
 * @method date($column = 'date', $default = false)
 * @method timestamps()
 */
return new class () implements MigrationInterface {
    public function up()
    {
        /** @phpstan-ignore-next-line */
        Schema::table('$TABLE')
            ->uuid('id')


            ->timestamps()
            ->create();

    }


    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        /** @phpstan-ignore-next-line */
        Schema::dropIfExists('$TABLE');
    }
};
