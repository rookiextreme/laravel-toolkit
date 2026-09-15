<?php

namespace Database\Seeders;

use App\Models\CountryLookup;
use App\Models\StateLookup;
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

        $malaysia = CountryLookup::where('s_name', 'Malaysia')->first();

        foreach($states as $st){
            StateLookup::updateOrCreate(
                [
                    'name' => $st,
                ],
                [
                    'name' => $st,
                    's_name' => $st,
                    'country_lookup_id' => $malaysia->id,
                ]
            );
        }
    }
}
