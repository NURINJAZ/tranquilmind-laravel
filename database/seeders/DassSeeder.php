<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Dass;


class DassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

            Dass::create([
                'user_id' => 24,
                'depression_score' => 16,
                'anxiety_score' => 12,
                'stress_score' => 19,
                'category' => 47,
            ]);
    }
}
