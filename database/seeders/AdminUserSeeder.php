<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'password' => bcrypt('lti1p3_admin'),
            'email' => 'admin@lti1p3.cl',
            'creation_method' => 'MANUAL',
            'app_role' => 'ADMIN',
        ]);
    }
}
