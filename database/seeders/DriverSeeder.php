<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $password = 'password';

        for ($i=0; $i < 10; $i++) {
            $email = 'driver'.$i.'@gmail.com';

            $user = User::where('email',$email)->first();
            if($user){
                $this->command->info($email . ' Already in records!');
            }
            else{
                User::create([
                    'name' => 'driver'.$i,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role' => 'Driver'
                ]);
                $this->command->info('Record created with: '.$email.' Password: '.$password);
            }
        }
    }
}
