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
         $this->call(UsersTableSeeder::class);
         $this->call(RoleSeeder::class);
         $this->call(KatosTableSeeder::class);
         $this->call(CountriesTableSeeder::class);
         $this->call(DoctypesTableSeeder::class);
         $this->call(GendersTableSeeder::class);
         $this->call(StatusesTableSeeder::class);
         $this->call(TargetsTableSeeder::class);
    }
}
