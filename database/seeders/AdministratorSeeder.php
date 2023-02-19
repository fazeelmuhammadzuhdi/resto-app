<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new User();
        $administrator->name = 'Fazeel';
        $administrator->email = 'fazeel@gmail.com';
        $administrator->roles = 'admin';
        $administrator->password = bcrypt('admin123');
        $administrator->save();
    }
}
