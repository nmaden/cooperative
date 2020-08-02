<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $find = \App\Models\User::query()->where('email','=','admin@gmail.com')->first();
        if ($find != null) {
            \App\Models\User::create([
                'name'=>'Name',
                'surname'=>'Surname',
                'email'=>'admin@gmail.com',
                'password'=>bcrypt('admin@gmail.com')
            ]);
        }

    }
}
