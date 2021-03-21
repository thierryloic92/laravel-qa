<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $faker = Faker::create ();
        // $categories = [];
        // foreach (range(1,5) as $index) {
        //     $categories [] = [
        //         'name' => $faker->text(20),
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ];
        // }
        // DB::table('categories')->insert($categories);

        factory(Category::class,5)->create();
    }
}
