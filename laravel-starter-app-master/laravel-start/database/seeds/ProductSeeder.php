<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use App\Models\Product as Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = Faker::create ();
        // $products = [];

        // foreach (range(1,20) as $index) {
        //     $products [] = [
        //         'name' => $faker->sentence,
        //         'price' => $faker->randomDigitNot(0) *10,
        //         'category_id' => rand(3,5),
        //         'created_at' => now (),
        //         'updated_at' => now ()

        //     ];
        // }

        // DB::table('products')->insert($products);

        factory(Product::class,20)->create();
    }
}
