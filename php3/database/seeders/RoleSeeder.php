<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Danh sách vai trò cố định
        $roles = ['Admin', 'Editor', 'Subscriber'];

        // Tạo vai trò từ danh sách
        foreach ($roles as $name) {
            Role::firstOrCreate(['name' => $name], [
                'name' => $name,
            ]);
        }
    }
}
