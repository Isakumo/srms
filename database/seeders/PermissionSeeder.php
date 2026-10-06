<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        School::query()->updateOrCreate([
            'code' => 'demo-school',
        ], [
            'name' => 'Demo School',
            'motto' => 'Knowledge, Discipline, Excellence',
            'status' => 'ACTIVE',
        ]);
    }
}
