<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModalHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('model_has_roles')->insert([
            ['role_id' => 1, 'model_type' => 'Chiiya\\FilamentAccessControl\\Models\\FilamentUser', 'model_id' => 1],
            ['role_id' => 1, 'model_type' => 'Chiiya\\FilamentAccessControl\\Models\\FilamentUser', 'model_id' => 2],
            ['role_id' => 1, 'model_type' => 'Chiiya\\FilamentAccessControl\\Models\\FilamentUser', 'model_id' => 3],
            ['role_id' => 1, 'model_type' => 'Chiiya\\FilamentAccessControl\\Models\\FilamentUser', 'model_id' => 4],
            ['role_id' => 1, 'model_type' => 'Chiiya\\FilamentAccessControl\\Models\\FilamentUser', 'model_id' => 14],
            ['role_id' => 1, 'model_type' => 'Chiiya\\FilamentAccessControl\\Models\\FilamentUser', 'model_id' => 15],
            ['role_id' => 1, 'model_type' => 'Chiiya\\FilamentAccessControl\\Models\\FilamentUser', 'model_id' => 16],
        ]);
    }
}
