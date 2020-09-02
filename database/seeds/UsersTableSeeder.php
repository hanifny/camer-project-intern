<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id'       => '4f41d354-10b4-4a23-b8cf-e9b4e1b202ab',
            'nama'     => 'Hanif Nuryanto',
            'email'    => 'hanif@uaf.com',
            'password' => bcrypt('secret'),
            'role_id'  => '78e83712-9bfe-4bd2-9689-886324a48acb'
        ]);
    }
}
