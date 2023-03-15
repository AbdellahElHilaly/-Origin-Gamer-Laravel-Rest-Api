<?php

namespace Database\Seeders;

use App\Models\Rule;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rules = [
            [
                'name' => 'guest',
                'description' => 'Guest user : can only read',
            ],
            [
                'name' => 'developer',
                'description' => 'Developer : can read, create, update and delete all games data',
            ],
            [
                'name' => 'admin',
                'description' => 'Admin : can read, create, update and delete all games data and users data and categories data'
            ],
        ];

        foreach ($rules as $rule) {
            Rule::create($rule);
        }
    }
}
