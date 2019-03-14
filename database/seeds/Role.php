<?php

use Illuminate\Database\Seeder;

class Role extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        	DB::table('roles')->delete();
        	$roleData = array(
        		array(
        			'id' => 1,
        			'name' => 'admin',
        			'display_name' => ' Admin',
        			'description' =>  'This is super admin role for login',
        			'created_at' =>  date("Y-m-d H:i:s"),
        			'updated_at' =>  date("Y-m-d H:i:s"),
        		),
        		array(
        			'id' =>2,
        			'name' => 'client',
        			'display_name' => 'client',
        			'description' => 'client role',
        			'created_at' =>  date("Y-m-d H:i:s"),
        			'updated_at' =>  date("Y-m-d H:i:s"),
        		),
        		array(
        			'id' =>3,
        			'name' => 'buyer',
        			'display_name' => 'Buyer',
        			'description' => 'Buyers, also known as purchasing agents, are are analyzers, negotiators and deal-makers. They research, evaluate and buy products for companies to either resell to customers or use in their everyday operations.',
        			'created_at' =>  date("Y-m-d H:i:s"),
        			'updated_at' =>  date("Y-m-d H:i:s"),
        		),
        	);
        	DB::table('roles')->insert($roleData);
    }
}
