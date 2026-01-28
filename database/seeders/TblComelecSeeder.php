<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class TblComelecSeeder extends Seeder
{
    public function run()
    {
        $csv = Reader::createFromPath(database_path('seeders/tblcomelec.csv'), 'r');
        $csv->setHeaderOffset(0); // first row as header

        foreach ($csv as $record) {
            DB::table('tblcomelec')->insert($record);
        }
    }
}
