<?php

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
        $rows = [
            ['email' => 'admin@admin.com', 'password' => bcrypt(1), 'name' => 'Admin']
        ];

        foreach($rows as $row) {
            User::create($row);
        }
    }
}
