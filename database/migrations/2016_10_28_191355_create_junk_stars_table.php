<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJunkStarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("
            CREATE TABLE IF NOT EXISTS `junk_stars` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `ppmxl_id` bigint(20) NOT NULL,
                `ra` decimal(10,6) DEFAULT NULL,
                `decl` decimal(10,6) DEFAULT NULL,
                `b1mag` decimal(3,1) DEFAULT NULL,
                `b2mag` decimal(3,1) DEFAULT NULL,
                `r1mag` decimal(3,1) DEFAULT NULL,
                `r2mag` decimal(3,1) DEFAULT NULL,
                `imag` decimal(3,1) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `junk_stars_b1magIdx` (`b1mag`),
                KEY `junk_stars_b2magIdx` (`b2mag`),
                KEY `junk_stars_r1magIdx` (`r1mag`),
                KEY `junk_stars_r2magIdx` (`r2mag`),
                KEY `junk_stars_imagIdx` (`imag`)
            ) ENGINE=InnoDB AUTO_INCREMENT=22924638 DEFAULT CHARSET=latin1;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('junk_stars');
    }
}
