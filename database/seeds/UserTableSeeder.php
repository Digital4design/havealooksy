<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $userData = array(
            array(
                'id' => 1,
                'first_name'=>'Admin',
                'last_name'=>'Test',
                'postal_code'=>'160055',
                'user_name' => 'admin_d4d',
                'email' => 'devd4d@yopmail.com',
                'email_verified_at' =>  date("Y-m-d H:i:s"),
                'password' => '$2y$10$tBbYloTaIO771zhXsfLbw.FI1qB7l7wlgwhRthdQBc0VK0dASGIfC',
                'remember_token' => null,
                'created_at' =>  date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 2,
                'first_name'=>'Seller',
                'last_name'=>'Test',
                'postal_code'=>'160055',
                'user_name' => 'seller_d4d',
                'email' => 'sellerd4d@yopmail.com',
                'email_verified_at' =>  date("Y-m-d H:i:s"),
                'password' => '$2y$10$tBbYloTaIO771zhXsfLbw.FI1qB7l7wlgwhRthdQBc0VK0dASGIfC',
                'remember_token' => null,
                'created_at' =>  date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 3,
                'first_name'=>'Buyer',
                'last_name'=>'Test',
                'postal_code'=>'160055',
                'user_name' => 'buyer_d4d',
                'email' => 'buyerd4d@yopmail.com',
                'email_verified_at' =>  date("Y-m-d H:i:s"),
                'password' => '$2y$10$tBbYloTaIO771zhXsfLbw.FI1qB7l7wlgwhRthdQBc0VK0dASGIfC',
                'remember_token' => null,
                'created_at' =>  date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s"),
            ),
        );
        DB::table('users')->insert($userData);
    }
}
