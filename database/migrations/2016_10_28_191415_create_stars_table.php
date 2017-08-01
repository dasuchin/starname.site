<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("
            CREATE TABLE IF NOT EXISTS `stars` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(60) DEFAULT NULL,
                `ra` decimal(10,6) DEFAULT NULL,
                `proper_motion_ra` decimal(10,0) DEFAULT NULL,
                `proper_motion_ra_error` decimal(10,0) DEFAULT NULL,
                `ra_epoch` decimal(10,0) DEFAULT NULL,
                `decl` decimal(10,6) DEFAULT NULL,
                `proper_motion_dec` decimal(10,0) DEFAULT NULL,
                `proper_motion_dec_error` int(11) DEFAULT NULL,
                `dec_epoch` decimal(10,0) DEFAULT NULL,
                `position_error` decimal(10,0) DEFAULT NULL,
                `lii` decimal(10,0) DEFAULT NULL,
                `bii` decimal(10,0) DEFAULT NULL,
                `pg_mag` decimal(3,1) DEFAULT NULL,
                `vmag` decimal(3,1) DEFAULT NULL,
                `spect_type` varchar(3) DEFAULT NULL,
                `ref_vmag` int(11) DEFAULT NULL,
                `ref_star_number` int(11) DEFAULT NULL,
                `ref_pg_mag` int(11) DEFAULT NULL,
                `ref_proper_motion` int(11) DEFAULT NULL,
                `ref_spect_type` int(11) DEFAULT NULL,
                `remarks` int(11) DEFAULT NULL,
                `ref_source_cat` int(11) DEFAULT NULL,
                `num_source_cat` int(11) DEFAULT NULL,
                `dm` varchar(13) DEFAULT NULL,
                `hd` varchar(6) DEFAULT NULL,
                `hd_component` varchar(1) DEFAULT NULL,
                `gc` varchar(5) DEFAULT NULL,
                `proper_motion_ra_fk5` decimal(10,0) DEFAULT NULL,
                `proper_motion_dec_fk5` decimal(10,0) DEFAULT NULL,
                `class` int(11) DEFAULT NULL,
                `ppmxl_id` bigint(20) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `stars_vmagIdx` (`vmag`)
            ) ENGINE=InnoDB AUTO_INCREMENT=526019 DEFAULT CHARSET=latin1;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stars');
    }
}
