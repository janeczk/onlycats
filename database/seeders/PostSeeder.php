<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $john = User::where('email', 'john.doe@gmail.com')->first();
        $anna = User::where('email', 'anna@gmail.com')->first();
        $wilson = User::where('email', 'wilson@gmail.com')->first();

        if ($john) {
            DB::table('posts')->insert([
                'content' => '#small #cute #ilovemycat',
                'photo' => 'posts/cat4.jpg',
                'user_id' => $john->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => '#cute #cold',
                'photo' => 'posts/cat11.jpg',
                'user_id' => $john->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => '#feet',
                'photo' => 'posts/cat8.jpg',
                'user_id' => $john->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            echo "User John not found. Post not created.\n";
        }

        if ($anna) {
            DB::table('posts')->insert([
                'content' => '#funny #trapedcat #bigbelly',
                'photo' => 'posts/cat3.jpeg',
                'user_id' => $anna->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('posts')->insert([
                'content' => '#angry #LeaveMeAlone #precious',
                'photo' => 'posts/cat10.jpg',
                'user_id' => $anna->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => '#begging #for #food',
                'photo' => 'posts/cat13.jpg',
                'user_id' => $anna->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => '#loaf  #challenge',
                'photo' => 'posts/cat6.jpg',
                'user_id' => $anna->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            echo "User Anna not found. Posts not created.\n";
        }

        if ($wilson) {
            DB::table('posts')->insert([
                'content' => '#feet',
                'photo' => 'posts/cat1.jpg',
                'user_id' => $wilson->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('posts')->insert([
                'content' => '#loaf #challenge',
                'photo' => 'posts/cat7.jpeg',
                'user_id' => $wilson->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            echo "User Wilson not found. Post not created.\n";
        }

    }
}
