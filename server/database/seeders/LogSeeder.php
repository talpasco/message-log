<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Log;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/logs.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Log::create(array(
                'usr_id' => $obj->usr_id,
                'num_id' => $obj->num_id,
                'log_message' => $obj->log_message,
                'log_success' => $obj->log_success,
                'log_created' => $obj->log_created
            ));
        }
    }
}
