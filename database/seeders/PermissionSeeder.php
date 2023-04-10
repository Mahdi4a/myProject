<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Permission\Entities\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            'user' => 'کاربر',
            'role' => 'نقش',
            'permission' => 'دسترسی',
            'product' => 'محصول',
            'category' => 'دسته بندی',
        ];
        foreach ($array as $key => $item) {

            if ($key === 'category') {
                Permission::query()->create([
                    'name' => 'show-categories',
                    'label' => "نمایش {$item}",
                ]);
            } else {
                Permission::query()->create([
                    'name' => 'show-' . $key . 's',
                    'label' => "نمایش {$item}",
                ]);
            }
            Permission::query()->create([
                'name' => 'create-' . $key,
                'label' => "ایجاد {$item}",
            ]);
            Permission::query()->create([
                'name' => 'edit-' . $key,
                'label' => "ویرایش {$item}",
            ]);
            Permission::query()->create([
                'name' => 'delete-' . $key,
                'label' => "حذف {$item}",
            ]);
        }

        Permission::query()->create([
            'name' => 'approved-comments',
            'label' => "نظرات تایید شده",
        ]);
        Permission::query()->create([
            'name' => 'unapproved-comments',
            'label' => "نظرات تایید نشده",
        ]);
        Permission::query()->create([
            'name' => 'comments-manager',
            'label' => "مدیریت نظرات",
        ]);
        Permission::query()->create([
            'name' => 'delete-comment',
            'label' => "حذف نظرات",
        ]);
        Permission::query()->create([
            'name' => 'edit-comment',
            'label' => "ویرایش نظرات",
        ]);
    }
}
