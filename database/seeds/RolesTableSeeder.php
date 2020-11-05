<?php

use App\Role;
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
        Role::create([
            'id' => '42855eb8-6193-48ae-913c-aec7dea8eeb9',
            'nama' => 'SuperAdmin'
        ]);
        Role::create([
            'id'   => '78e83712-9bfe-4bd2-9689-886324a48acb',
            'nama' => 'Admin',
        ]);
        Role::create([
            'id' => '9db7170e-7d23-4b16-98a0-095f4c3c1f6a',
            'nama' => 'Engineer',
        ]);
    }
}
