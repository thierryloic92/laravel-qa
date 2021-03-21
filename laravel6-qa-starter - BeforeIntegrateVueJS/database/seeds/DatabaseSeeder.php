<?php

use App\Models\Question;
use VotablesTableSeeder;
use Illuminate\Database\Seeder;
use UsersQuestionsAnswersTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // factory(App\User::class, 3)->create()->each(function($u) {
        //     $u->questions()
        //       ->saveMany(
        //           factory(App\Models\Question::class, rand(1, 5))->make()
        //       )->each(function ($q){
        //           $q->answers()->saveMany(
        //               factory(App\Models\Answer::class,rand(1,5))->make()
        //           );
        //       });
        // });
        // $this->call(UsersTableSeeder::class);
        //factory(App\User::class,5)->create();
        //factory(Question::class,30)->create();
        // factory(App\User::class,3)->create()->each(function($user){
        //     $user->questions()
        //     ->saveMany(
        //         factory(Question::class)->make()
        //     );
        // });
        // factory(App\Models\Question::class,20)->create();
        // $this->call([
        //     UsersQuestionsAnswersTableSeeder::class,
        //     FavoritesTableSeeder::class,
        //     VotablesTableSeeder::class
        // ]);
    }
}
