<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Role::query()->where('name','=','Администратор системы')->first()) {
            $role = Role::create(['name' => 'Администратор системы']);
            $user = \App\Models\User::query()->findOrFail(1);
            $user->assignRole($role);
        }
        if (!Role::query()->where('name','=','Администратор ГО')->first()) {
            $role = Role::create(['name' => 'Администратор ГО']);
        }
        if (!Role::query()->where('name','=','Пользователь ГО')->first()) {
            $role = Role::create(['name' => 'Пользователь ГО']);
        }
        if (!Role::query()->where('name','=','Администратор МР')->first()) {
            $role = Role::create(['name' => 'Администратор МР']);
        }
        if (!Role::query()->where('name','=','Пользователь МР')->first()) {
            $role = Role::create(['name' => 'Пользователь МР']);
        }

    }
}
