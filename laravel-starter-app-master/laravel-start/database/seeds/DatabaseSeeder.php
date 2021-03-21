<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        // $this->call([
        //     CategorySeeder::class,
        //     ProductSeeder::class
        // ]);

        // Je peux aller directement mes Factorys pourvu juste qu'ils soient dans l'ordre
        factory(Category::class,5)->create();
        factory(Product::class,20)->create();
    }
}
