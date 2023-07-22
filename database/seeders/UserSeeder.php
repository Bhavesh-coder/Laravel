<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::create([
            'type' => User::USER,
            'name' => 'Default User',
            'email' => 'test@gmail.com',
            'password' => bcrypt('password')
        ]);
        User::create([
            'type' => User::ADMIN,
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);
        $unverified_users = User::factory(10)->unverified()->create();
        $verified_users = User::factory(10)->verified()->create();

        foreach ($verified_users as $user) {
            $user_ids = User::inRandomOrder()->where('id', '!=', $user->id)->limit(rand(0, 5))->get()->pluck('id');
            $user->followers()->sync($user_ids);
        }
    }
}