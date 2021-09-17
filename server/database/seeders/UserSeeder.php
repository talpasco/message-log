<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/users.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            User::create(array(
                'usr_name' => $obj->usr_name,
                'usr_active' => $obj->usr_active,
                'usr_created' => $obj->usr_created
            ));
        }
    }
}