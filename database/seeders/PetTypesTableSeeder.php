<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PetTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pet_types')->insert([
            ['type' => 'hond', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'kat', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'vis', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'konijn', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
