<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@gmail.com';
        $password = 'password';

        $user = User::where('email',$email)->first();
        if($user){
            $this->command->info($email . ' Already in records!');
        }
        else{
            User::create([
                'name' => 'admin',
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'Admin'
            ]);
            $this->command->info('Record created with: '.$email.' Password: '.$password);
        }
    }
}
