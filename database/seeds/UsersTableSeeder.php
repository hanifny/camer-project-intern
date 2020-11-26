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
            'name'     => 'Hanif Nuryanto',
            'username'    => 'hanif',
            'password' => bcrypt('secret'),
            'role_id'  => '42855eb8-6193-48ae-913c-aec7dea8eeb9'
        ]);
        User::create([
            'name'     => 'Moch Dicky',
            'username'    => 'dicky',
            'password' => bcrypt('secret'),
            'role_id'  => '78e83712-9bfe-4bd2-9689-886324a48acb'
        ]);
        User::create([
            'name'     => 'Danes Novigar',
            'username'    => 'danes',
            'password' => bcrypt('secret'),
            'role_id'  => '9db7170e-7d23-4b16-98a0-095f4c3c1f6a'
        ]);
        User::create([
            'name'     => 'Rizki Akbaraziz',
            'username'    => 'rizki',
            'password' => bcrypt('secret'),
            'role_id'  => '9db7170e-7d23-4b16-98a0-095f4c3c1f6a'
        ]);
    }
}
