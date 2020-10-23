<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name' => "test",
            'email' => "test@test",
            'password' => "test1234",
        ]);
        factory(User::class, 100)->create();
    }
}
