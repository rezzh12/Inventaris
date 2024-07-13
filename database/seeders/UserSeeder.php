<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               
                'name'      => 'Staff',
                'username'  => 'Staff',
                'email'     => 'Staff@gmail.com',
                'password'  => bcrypt('12345'),
                'roles_id'  => 3
            ],
            [
               
                'name'      => 'Sarana',
                'username'  => 'Sarana',
                'email'     => 'Sarana@gmail.com',
                'password'  => bcrypt('12345'),
                'roles_id'  => 2
            ],
            [
                
                'name'      => 'Kepala',
                'username'  => 'Kepala',
                'email'     => 'Kepala@gmail.com',
                'password'  => bcrypt('12345'),
                'roles_id'  => 1
            ]
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}