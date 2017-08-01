<?php

use App\Models\Order;
use App\Models\Customer;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUuids extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('customers', 'uuid')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->char('uuid', 255)->default('');
            });

            foreach (Customer::all() as $customer) {
                $customer->uuid = Uuid::generate(4);
                $customer->save();
            }
        }

        if (!Schema::hasColumn('orders', 'uuid')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->char('uuid', 255)->default('');
            });

            foreach (Order::all() as $order) {
                $order->uuid = Uuid::generate(4);
                $order->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
}
