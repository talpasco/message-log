<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/countries.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Country::create(array(
                'cnt_code' => $obj->cnt_code,
                'cnt_title' => $obj->cnt_title,
                'cnt_created' => $obj->cnt_created
            ));
        }
    }
}