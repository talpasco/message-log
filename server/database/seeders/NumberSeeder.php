<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Number;

class NumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/numbers.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Number::create(array(
                'cnt_id' => $obj->cnt_id,
                'num_number' => $obj->num_number,
                'num_created' => $obj->num_created
            ));
        }
    }
}