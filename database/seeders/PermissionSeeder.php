<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            'name' => 'admin-users.view',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'admin-users.create',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'admin-users.update',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'admin-users.delete',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permissions.update',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'engagement.view',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'engagement.create',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'engagement.edit',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'engagement.delete',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'issue.view',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'issue.create',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'issue.edit',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'issue.delete',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'response.view',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'response.create',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'response.edit',
            'guard_name' => 'filament',
        ]);
        DB::table('permissions')->insert([
            'name' => 'response.delete',
            'guard_name' => 'filament',
        ]);
    }
}
