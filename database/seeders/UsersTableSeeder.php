<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
                [
                    'name' => 'Sybluse',
                    'email' => 'syb@gmail.com',
                    'password' => bcrypt('1234567880'),
                    'rule_id' => 1,
                ],
                [
                    'name' => 'garena free fire',
                    'email' => 'garena@gmail.com',
                    'password' => bcrypt('1234567880'),
                    'rule_id' => 2,
                ],
                [
                    'name' => 'Konami',
                    'email' => 'Konami@gmail.com',
                    'password' => bcrypt('1234567880'),
                    'rule_id' => 2,
                ],
                [
                    'name' => 'abdellah',
                    'email' => 'abdellah@gmail.com',
                    'password' => bcrypt('1234567880'),
                    'rule_id' => 3,
                ]

            ];

        foreach ($users as $user) {
            User::create($user);
        }


    }
}
