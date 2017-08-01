<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->char('uuid', 36)->default('');
            $table->integer('user_id');
            $table->text('stripe_customer_id');
            $table->text('email');
            $table->integer('cc_last4');
            $table->text('cc_type');
            $table->integer('cc_exp_month');
            $table->integer('cc_exp_year');
            $table->text('cc_fingerprint');
            $table->text('cc_country');
            $table->text('cc_name');
            $table->text('cc_address_line1');
            $table->text('cc_address_line2')->nullable();
            $table->text('cc_address_city');
            $table->text('cc_address_state');
            $table->text('cc_address_zip');
            $table->text('cc_address_country');
            $table->text('plan')->nullable();
            $table->datetime('cancel_date')->nullable();
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
        Schema::drop('customers');
    }
}
