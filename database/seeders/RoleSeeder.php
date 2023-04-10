<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Permission\Entities\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->create([
            'name' => 'manage-users',
            'label' => 'مدیریت کاربران',
        ]);
        Role::query()->create([
            'name' => 'writer',
            'label' => 'ویراستار',
        ]);
        Role::query()->create([
            'name' => 'manager',
            'label' => 'مدیریت',
        ]);
    }
}
