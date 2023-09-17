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
        $user_id = DB::table('lti1p3_users')->insertGetId([
            'name' => 'Admin',
            'password' => bcrypt('lti1p3_admin'),
            'email' => 'admin@lti1p3.cl',
            'creation_method' => 'MANUAL',
        ]);

        DB::table('lti1p3_user_roles')->insert([
            'user_id' => $user_id,
            'name' => 'administrator',
            'creation_context' => 'LOCAL'
        ]);
    }
}
