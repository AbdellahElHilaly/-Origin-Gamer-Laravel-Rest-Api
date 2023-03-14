<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'description' => 'Learn web development skills'
            ],
            [
                'name' => 'Mobile Development',
                'description' => 'Learn mobile app development skills'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
