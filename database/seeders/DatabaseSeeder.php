<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FilesTableSeeder::class,
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            OrderStatusesTableSeeder::class,
            ProductsTableSeeder::class,
            PaymentsTableSeeder::class,
            OrdersableSeeder::class,
        ]);
    }
}
