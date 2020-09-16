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
            'tipe' => '1BA',
            'luas' => 46.80,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => '1BC',
            'luas' => 48.10,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => '1BDT',
            // 'luas' => null,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => '1BSCT',
            'luas' => 44.75,
            'daya_ampere' => 10
        ]);

        Type::create([
            'tipe' => '1BST',
            'luas' => 43.30,
            'daya_ampere' => 10
        ]);

        Type::create([
            'tipe' => '2BA',
            'luas' => 46.60,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => '2BA-G1',
            'luas' => 60.20,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => '2BA-G2',
            'luas' => 73.20,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => '2BAT',
            'luas' => 56.10,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => '2BB',
            'luas' => 46.80,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => '2BBT',
            'luas' => 56.10,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => '2BC',
            'luas' => 47.90,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => '2BCT',
            'luas' => 43.30,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => '2BD1',
            'luas' => 46.60,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => '2BD2',
            'luas' => 46.80,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => '2BDT',
            'luas' => 43.30,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => '2BET',
            'luas' => 67.15,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => '3BA',
            'luas' => 71.60,
            'daya_ampere' => 20
        ]);

        Type::create([
            'tipe' => '3BB',
            'luas' => 70.16,
            'daya_ampere' => 20
        ]);

        Type::create([
            'tipe' => '3BC1',
            'luas' => 71.60,
            'daya_ampere' => 20
        ]);

        Type::create([
            'tipe' => '3BC2',
            'luas' => 71.16,
            'daya_ampere' => 20
        ]);

        Type::create([
            'tipe' => '3BCAT',
            'luas' => 86.40,
            'daya_ampere' => 20
        ]);

        Type::create([
            'tipe' => '3BCBT',
            'luas' => 86.40,
            'daya_ampere' => 20
        ]);

        Type::create([
            'tipe' => '3BCCT',
            'luas' => 72.80,
            'daya_ampere' => 20
        ]);

        Type::create([
            'tipe' => '3BCDT',
            // 'luas' => null,
            'daya_ampere' => 40
        ]);

        Type::create([
            'tipe' => '3BDT',
            'luas' => 100.49,
            'daya_ampere' => 40
        ]);

        Type::create([
            'tipe' => 'SSA',
            'luas' => 46.60,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => 'SSC',
            'luas' => 47.90,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => 'STA',
            'luas' => 23.25,
            'daya_ampere' => 10
        ]);

        Type::create([
            'tipe' => 'STAT',
            'luas' => 28.05,
            'daya_ampere' => 10
        ]);

        Type::create([
            'tipe' => 'STB',
            'luas' => 23.25,
            'daya_ampere' => 10
        ]);

        Type::create([
            'tipe' => 'STBT',
            'luas' => 28.05,
            'daya_ampere' => 10
        ]);

        Type::create([
            'tipe' => 'STC',
            'luas' => 24.55,
            'daya_ampere' => 10
        ]);

        Type::create([
            'tipe' => 'PHA',
            'luas' => 460.60,
            'daya_ampere' => 35
        ]);

        Type::create([
            'tipe' => 'PHB',
            'luas' => 216.10,
            'daya_ampere' => 20
        ]);

        Type::create([
            'tipe' => 'PHC',
            'luas' => 211.10,
            'daya_ampere' => 20
        ]);

        Type::create([
            'tipe' => 'PHD',
            'luas' => 160.25,
            'daya_ampere' => 20
        ]);

        Type::create([
            'tipe' => 'PHE-B',
            'luas' => 208.28,
            'daya_ampere' => 20
        ]);

        Type::create([
            'tipe' => 'PHEC',
            'luas' => 111.02,
            'daya_ampere' => 20
        ]);

        Type::create([
            'tipe' => 'PH-ECB',
            'luas' => 113.48,
            'daya_ampere' => 20
        ]);

        Type::create([
            'tipe' => 'PHF',
            'luas' => 167.05,
            'daya_ampere' => 20
        ]);

        Type::create([
            'tipe' => 'PHG',
            'luas' => 124.05,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => 'PHJ',
            'luas' => 126.00,
            'daya_ampere' => 16
        ]);

        Type::create([
            'tipe' => 'SINARMAS',
            // 'luas' => null,
            'daya_ampere' => 40
        ]);
    }
}
