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
            'nama'     => 'Hanif Nuryanto',
            'email'    => 'hanif@uaf.com',
            'password' => bcrypt('secret'),
            'role_id'  => '2db7170e-7d23-4b16-98a0-095f4c3c1f6a'
        ]);
        User::create([
            'nama'     => 'Moch Dicky',
            'email'    => 'dicky@uaf.com',
            'password' => bcrypt('secret'),
            'role_id'  => '78e83712-9bfe-4bd2-9689-886324a48acb'
        ]);
    }
}
