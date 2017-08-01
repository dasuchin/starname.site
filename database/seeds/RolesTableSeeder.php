<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = Role::where('name', 'user');
        $adminRole = Role::where('name', 'administrator');

        if ($userRole->count() < 1 && $adminRole->count() < 1) {
            Role::where('id', 'like', '%%')->delete();

            Role::create([
                'name' => 'user'
            ]);

            Role::create([
                'name' => 'administrator'
            ]);
        }
    }
}
