<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        \DB::table('users')->insert([
            'master' => 1,
            'name' => 'master',
            'email' => 'master@erp.com',
            'password' => bcrypt('secret')
        ]);
    }
}
