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
                'last_name'=>'Admin',
                'postal_code'=>'160055',
                'user_name' => 'admin',
                'email' => 'devd4d@yopmail.com',
                'email_verified_at' =>  date("Y-m-d H:i:s"),
                'password' => '$2y$10$0leNvhKDVvkFW/WpYGrxoOyxLVZNAsYZnUybEjx.C7Id6UInOkaj2',
                'remember_token' => null,
                'created_at' =>  date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 2,
                'first_name'=>'Admin2',
                'last_name'=>'Admin2',
                'postal_code'=>'160055',
                'user_name' => 'admin2',
                'email' => 'sallerd4d@yopmail.com',
                'email_verified_at' =>  date("Y-m-d H:i:s"),
                'password' => '$2y$10$0leNvhKDVvkFW/WpYGrxoOyxLVZNAsYZnUybEjx.C7Id6UInOkaj2',
                'remember_token' => null,
                'created_at' =>  date("Y-m-d H:i:s"),
                'updated_at' =>  date("Y-m-d H:i:s"),
            ),
        );
        DB::table('users')->insert($userData);
    }
}
