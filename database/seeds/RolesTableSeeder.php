<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'Admin',
                'level' => 5,
                'color' => '#FF0000'
            ],
            [
                'id'    => 2,
                'title' => 'Manager',
                'level' => 4,
                'color' => '#FFFF00'
            ],
            [
                'id'    => 3,
                'title' => 'Staff',
                'level' => 3,
                'color' => '#00FF00'
            ],
            [
                'id'    => 4,
                'title' => 'Internship',
                'level' => 2,
                'color' => '#0000FF'
            ],
            [
                'id'    => 5,
                'title' => 'Collaborator',
                'level' => 1,
                'color' => '#00FFFF'
            ],
            [
                'id'    => 6,
                'title' => 'Apprentice',
                'level' => 0,
                'color' => '#FF00FF'
            ],
        ];

        Role::insert($roles);
    }
}
