<?php

namespace Database\Seeders;

use App\Models\Family;
use Illuminate\Database\Seeder;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $families = [
            [
                'id' => 1,
                'name' => 'Budi',
                'gender' => 'L',
                'father_id' => NULL
            ],
            [
                'id' => 2,
                'name' => 'Dedi',
                'gender' => 'L',
                'father_id' => 1
            ],
            [
                'id' => 3,
                'name' => 'Feri',
                'gender' => 'L',
                'father_id' => 2
            ],
            [
                'id' => 4,
                'name' => 'Farah',
                'gender' => 'P',
                'father_id' => 2
            ],
            [
                'id' => 5,
                'name' => 'Dodi',
                'gender' => 'L',
                'father_id' => 1
            ],
            [
                'id' => 6,
                'name' => 'Gugus',
                'gender' => 'L',
                'father_id' => 5
            ],
            [
                'id' => 7,
                'name' => 'Gandi',
                'gender' => 'L',
                'father_id' => 5
            ],
            [
                'id' => 8,
                'name' => 'Dede',
                'gender' => 'L',
                'father_id' => 1
            ],
            [
                'id' => 9,
                'name' => 'Hani',
                'gender' => 'P',
                'father_id' => 8
            ],
            [
                'id' => 10,
                'name' => 'Hana',
                'gender' => 'P',
                'father_id' => 8
            ],
            [
                'id' => 11,
                'name' => 'Dewi',
                'gender' => 'P',
                'father_id' => 1
            ]
        ];

        foreach ($families as $family) {
            Family::query()
                ->create([
                    'name' => $family['name'],
                    'gender' => $family['gender'],
                    'father_id' => $family['father_id'],
                ]);
        }
    }
}
