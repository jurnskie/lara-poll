<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $questions = Question::factory(10)
            ->has(Answer::factory()->count(rand(1,4)))
            ->create();

        User::create([
            'name' => 'jurn',
            'email' => 'jurnskie@gmail.com',
            'password' => Hash::make('1234')
        ]);


    }
}
