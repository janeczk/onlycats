<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



        // Pobranie maksymalnego ID z tabeli users i upewnienie się, że wynik to liczba
        $maxId = DB::table('users')->max('id');
        $maxId = is_numeric($maxId) ? (int) $maxId : 0;

        DB::table('users')->insert([

            [
                'name' => 'John Doe',
                'email' => 'john.doe@gmail.com',
                'password' => bcrypt('secret'),
                'bio' => 'Hello. Im Joe and I love cats!',
                'username' => '@u' . str_pad((string) ($maxId + 1), 4, '0', STR_PAD_LEFT), // Generowanie username
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane.doe@gmail.com',
                'password' => bcrypt('secret2'),
                'bio' => 'Im here just to see some cute cats.',
                'username' => '@u' . str_pad((string) ($maxId + 2), 4, '0', STR_PAD_LEFT), // Generowanie username
            ],
            [
                'name' => 'Ana Smith',
                'email' => 'anna@gmail.com',
                'password' => bcrypt('secret3'),
                'bio' => null,
                'username' => '@u' . str_pad((string) ($maxId + 3), 4, '0', STR_PAD_LEFT), // Generowanie username
            ],
            [
                'name' => 'Mark Wilson',
                'email' => 'wilson@gmail.com',
                'password' => bcrypt('secret4'),
                'bio' => "Looking for some challenges.",
                'username' => '@u' . str_pad((string) ($maxId + 4), 4, '0', STR_PAD_LEFT), // Generowanie username
            ],
        ]);

    }

}
