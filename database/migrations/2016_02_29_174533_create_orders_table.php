<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->char('uuid', 36)->default('');
            $table->integer('user_id');
            $table->integer('customer_id');
            $table->integer('star_id');
            $table->text('star_map');
            $table->text('package');
            $table->text('zodiac');
            $table->text('prefix');
            $table->text('name');
            $table->boolean('use_date');
            $table->timestamp('dedication_date')->nullable();
            $table->text('magnitude');
            $table->integer('sub_total');
            $table->integer('tax');
            $table->integer('total');
            $table->boolean('use_vip');
            $table->integer('star_x');
            $table->integer('star_y');
            $table->text('membership_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
