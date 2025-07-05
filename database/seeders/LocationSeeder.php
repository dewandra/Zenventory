<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // PERBAIKAN: Nonaktifkan pengecekan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel lokasi terlebih dahulu
        DB::table('locations')->truncate();

        $locations = [
            // Lorong A
            ['name' => 'A-01-R01-B01', 'zone' => 'A', 'aisle' => '01', 'rack' => 'R01', 'bin' => 'B01'],
            ['name' => 'A-01-R01-B02', 'zone' => 'A', 'aisle' => '01', 'rack' => 'R01', 'bin' => 'B02'],
            ['name' => 'A-01-R01-B03', 'zone' => 'A', 'aisle' => '01', 'rack' => 'R01', 'bin' => 'B03'],
            ['name' => 'A-01-R02-B01', 'zone' => 'A', 'aisle' => '01', 'rack' => 'R02', 'bin' => 'B01'],
            ['name' => 'A-01-R02-B02', 'zone' => 'A', 'aisle' => '01', 'rack' => 'R02', 'bin' => 'B02'],
            ['name' => 'A-01-R02-B03', 'zone' => 'A', 'aisle' => '01', 'rack' => 'R02', 'bin' => 'B03'],
            ['name' => 'A-01-R03-B01', 'zone' => 'A', 'aisle' => '01', 'rack' => 'R03', 'bin' => 'B01'],
            ['name' => 'A-01-R03-B02', 'zone' => 'A', 'aisle' => '01', 'rack' => 'R03', 'bin' => 'B02'],
            ['name' => 'A-01-R03-B03', 'zone' => 'A', 'aisle' => '01', 'rack' => 'R03', 'bin' => 'B03'],
            ['name' => 'A-01-R04-B01', 'zone' => 'A', 'aisle' => '01', 'rack' => 'R04', 'bin' => 'B01'],
            ['name' => 'A-01-R04-B02', 'zone' => 'A', 'aisle' => '01', 'rack' => 'R04', 'bin' => 'B02'],
            ['name' => 'A-01-R04-B03', 'zone' => 'A', 'aisle' => '01', 'rack' => 'R04', 'bin' => 'B03'],
            ['name' => 'A-01-R05-B01', 'zone' => 'A', 'aisle' => '01', 'rack' => 'R05', 'bin' => 'B01'],
            ['name' => 'A-01-R05-B02', 'zone' => 'A', 'aisle' => '01', 'rack' => 'R05', 'bin' => 'B02'],
            ['name' => 'A-01-R05-B03', 'zone' => 'A', 'aisle' => '01', 'rack' => 'R05', 'bin' => 'B03'],
            
            // Lorong B
            ['name' => 'B-02-R01-B01', 'zone' => 'B', 'aisle' => '02', 'rack' => 'R01', 'bin' => 'B01'],
            ['name' => 'B-02-R01-B02', 'zone' => 'B', 'aisle' => '02', 'rack' => 'R01', 'bin' => 'B02'],
            ['name' => 'B-02-R01-B03', 'zone' => 'B', 'aisle' => '02', 'rack' => 'R01', 'bin' => 'B03'],
            ['name' => 'B-02-R02-B01', 'zone' => 'B', 'aisle' => '02', 'rack' => 'R02', 'bin' => 'B01'],
            ['name' => 'B-02-R02-B02', 'zone' => 'B', 'aisle' => '02', 'rack' => 'R02', 'bin' => 'B02'],
            ['name' => 'B-02-R02-B03', 'zone' => 'B', 'aisle' => '02', 'rack' => 'R02', 'bin' => 'B03'],
            ['name' => 'B-02-R03-B01', 'zone' => 'B', 'aisle' => '02', 'rack' => 'R03', 'bin' => 'B01'],
            ['name' => 'B-02-R03-B02', 'zone' => 'B', 'aisle' => '02', 'rack' => 'R03', 'bin' => 'B02'],
            ['name' => 'B-02-R03-B03', 'zone' => 'B', 'aisle' => '02', 'rack' => 'R03', 'bin' => 'B03'],
            ['name' => 'B-02-R04-B01', 'zone' => 'B', 'aisle' => '02', 'rack' => 'R04', 'bin' => 'B01'],
            ['name' => 'B-02-R04-B02', 'zone' => 'B', 'aisle' => '02', 'rack' => 'R04', 'bin' => 'B02'],
            ['name' => 'B-02-R04-B03', 'zone' => 'B', 'aisle' => '02', 'rack' => 'R04', 'bin' => 'B03'],
            ['name' => 'B-02-R05-B01', 'zone' => 'B', 'aisle' => '02', 'rack' => 'R05', 'bin' => 'B01'],
            ['name' => 'B-02-R05-B02', 'zone' => 'B', 'aisle' => '02', 'rack' => 'R05', 'bin' => 'B02'],
            ['name' => 'B-02-R05-B03', 'zone' => 'B', 'aisle' => '02', 'rack' => 'R05', 'bin' => 'B03'],
        ];

        // Masukkan data ke dalam database
        foreach ($locations as $location) {
            Location::create($location);
        }

        // PERBAIKAN: Aktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}