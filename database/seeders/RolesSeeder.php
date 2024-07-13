<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'Kepala Sekolah',

            ],
            [
                'id' => 2,
                'name' => 'Wks Bid Sarana',
            ],
            [
                'id' => 3,
                'name' => 'Staff',
            ],
        ];

        foreach ($roles as $key => $role) {
            Roles::create($role);
        }
    }
}