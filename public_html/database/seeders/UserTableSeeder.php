<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(config('admin.admin_username')) {
            User::firstOrCreate([
                "user_name" => config('admin.admin_username'),
                "rfid" => config('admin.admin_rfid'),
                "fullname" => config('admin.admin_fullname'),
                "phone" => config('admin.admin_phone'),
                "password" => bcrypt(config('admin.admin_password')),
                "gender" => config('admin.admin_gender'),
                "address" => config('admin.admin_address'),
                "id_number" => config('admin.admin_id_number'),
                "medical_insurance" => config('admin.admin_mi'),
                "email" => config('admin.admin_email'),
                "role" => config('admin.admin_role'),
                "birthday" => date("Y-m-d H:i:s")
            ]);
        }
    }
}
