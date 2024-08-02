<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pet_types')->insert([
            ['type' => 'hond'],
            ['type' => 'kat'],
            ['type' => 'vis'],
            ['type' => 'konijn'],
        ]);
    }
}
