<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModalHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('model_has_permissions')->insert([
            ['permission_id' => 5, 'model_type' => 'Chiiya\\FilamentAccessControl\\Models\\FilamentUser', 'model_id' => 2],
            ['permission_id' => 11, 'model_type' => 'Chiiya\\FilamentAccessControl\\Models\\FilamentUser', 'model_id' => 2],
        ]);
    }
}
