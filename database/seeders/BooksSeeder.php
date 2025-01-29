<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            'isbn' => '9781234567897',
            'title' => 'Sample Book',
            'description' => 'This is a dummy book description.',
        ]);
    }
}
