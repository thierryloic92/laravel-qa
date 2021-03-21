<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        //
        //'name','price','category_id'
        'name' => $faker->sentence,
        'price' => $faker->randomDigitNot(0) *10,
        'category_id' => Category::pluck('id')->random() //factory(Category::class)->create()->id ou factory(Category::class) -- Mais il faut savoir que si cela cree 10 produits ca va également créer 10 Categories
    ];
});
