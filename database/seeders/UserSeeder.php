<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = User::create([
        'name'        => 'User Admin',
        'email'       => 'admin@mail.com',
        'password'    => bcrypt('admin123'),
      ]);

      $user->assignRole('admin');
    }
}
