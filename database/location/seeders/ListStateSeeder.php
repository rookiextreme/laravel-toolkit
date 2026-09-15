<?php

namespace Database\Seeders;

use App\Models\ListCountry;
use App\Models\ListState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            'JHR' => 'Johor',
            'KDH' => 'Kedah',
            'KTN' => 'Kelantan',
            'MLK' => 'Melaka',
            'NSN' => 'Negeri Sembilan',
            'PHG' => 'Pahang',
            'PRK' => 'Perak',
            'PLS' => 'Perlis',
            'PNG' => 'Pulau Pinang',
            'SBH' => 'Sabah',
            'SWK' => 'Sarawak',
            'SGR' => 'Selangor',
            'TRG' => 'Terengganu',
            'KUL' => 'W.P Kuala Lumpur',
            'LBN' => 'W.P Labuan',
            'PJY' => 'W.P Putrajaya',
            'BRU' => 'Brunei',
            'BGK' => 'Bangkok'
        ];

        $malaysia = ListCountry::where('s_name', 'Malaysia')->first();

        foreach($states as $st){
            ListState::updateOrCreate(
                [
                    'name' => $st,
                ],
                [
                    'name' => $st,
                    's_name' => $st,
                    'list_country_id' => $malaysia->id,
                ]
            );
        }
    }
}
