<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(EntityTypeSeeder::class);
        $this->call(AttributeSeeder::class);
        $this->call(VarcharEavSeeder::class);
        $this->call(IntegerEavSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ShopcartSeeder::class);
        $this->call(ProductShopcartSeeder::class);
    }
}
