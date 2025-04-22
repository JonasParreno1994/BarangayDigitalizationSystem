<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run()
    {
        $positions = [
            'Barangay Captain',
            'Barangay Secretary',
            'Barangay Treasurer',
            'SK Chairman',
            'Councilor 1',
            'Councilor 2',
            
        ];

        foreach ($positions as $position) {
            Position::create(['position' => $position]);
        }
    }
}