<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$HvSDJRBDVWwRd18qj5oaQOF0DBXqnZcyFJ4dJA8hcQGAfmyZ7xkei',
                'remember_token' => null,
                'rate'           => 10,
            ],
            [
                'id'             => 2,
                'name'           => 'Manager',
                'email'          => 'manager@manager.com',
                'password'       => '$2y$10$HvSDJRBDVWwRd18qj5oaQOF0DBXqnZcyFJ4dJA8hcQGAfmyZ7xkei',
                'remember_token' => null,
                'rate'           => 5,
            ],
            [
                'id'             => 3,
                'name'           => 'Staff',
                'email'          => 'staff@staff.com',
                'password'       => '$2y$10$HvSDJRBDVWwRd18qj5oaQOF0DBXqnZcyFJ4dJA8hcQGAfmyZ7xkei',
                'remember_token' => null,
                'rate'           => 4,
            ],
            [
                'id'             => 4,
                'name'           => 'Internship',
                'email'          => 'internship@internship.com',
                'password'       => '$2y$10$HvSDJRBDVWwRd18qj5oaQOF0DBXqnZcyFJ4dJA8hcQGAfmyZ7xkei',
                'remember_token' => null,
                'rate'           => 3,
            ],
            [
                'id'             => 5,
                'name'           => 'Collaborator',
                'email'          => 'collaborator@collaborator.com',
                'password'       => '$2y$10$HvSDJRBDVWwRd18qj5oaQOF0DBXqnZcyFJ4dJA8hcQGAfmyZ7xkei',
                'remember_token' => null,
                'rate'           => 2,
            ],
            [
                'id'             => 6,
                'name'           => 'Apprentice',
                'email'          => 'apprentice@apprentice.com',
                'password'       => '$2y$10$HvSDJRBDVWwRd18qj5oaQOF0DBXqnZcyFJ4dJA8hcQGAfmyZ7xkei',
                'remember_token' => null,
                'rate'           => 1,
            ],
            [
                'id'             => 7,
                'name'           => 'Other',
                'email'          => 'other@other.com',
                'password'       => '$2y$10$HvSDJRBDVWwRd18qj5oaQOF0DBXqnZcyFJ4dJA8hcQGAfmyZ7xkei',
                'remember_token' => null,
                'rate'           => 0,
            ],
        ];

        User::insert($users);
    }
}
