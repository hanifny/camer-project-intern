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
            'id'   => '78e83712-9bfe-4bd2-9689-886324a48acb',
            'nama' => 'SuperAdmin',
        ]);
    }
}
