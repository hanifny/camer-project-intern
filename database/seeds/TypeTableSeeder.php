<?php

use App\Type;
use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'type' => '1BST',
            'luas' => 43.30,
            'daya_ampere' => 10
        ]);

        Type::create([
            'type' => '1BC',
            'luas' => 43.10,
            'daya_ampere' => 16
        ]);
    }
}
