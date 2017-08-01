<?php

use App\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = User::where('email', Config::get('app.admin_email'));
        if ($adminUser->count() < 1) {
            User::where('id', 'like', '%%')->delete();

            $adminRole = Role::where('name', 'administrator')->first();
            $user = User::create([
                'name' => 'Administrator',
                'email' => Config::get('app.admin_email'),
                'password' => bcrypt('test1234')
            ]);
            $user->assignRole($adminRole);
        }
    }
}
