<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleId = DB::table('roles')->where('name', 'super-admin')->first()->id;
        DB::table('filament_users')->insert([
            'first_name' => 'Tandin',
            'last_name' => 'Wangchuk',
            'email' => 'wangchuktandin@bnb.bt',
            'password' => bcrypt('1nt3rnal_@ud1t'),
            'role' => $roleId, // Specify the role
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
