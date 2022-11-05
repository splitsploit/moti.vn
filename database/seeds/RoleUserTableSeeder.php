<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        Role::findOrFail(1)->rolesUsers()->sync(1);
        Role::findOrFail(2)->rolesUsers()->sync(2);
        Role::findOrFail(3)->rolesUsers()->sync(3);
        Role::findOrFail(4)->rolesUsers()->sync(4);
        Role::findOrFail(5)->rolesUsers()->sync(5);
        Role::findOrFail(6)->rolesUsers()->sync([6, 7]);
    }
}
