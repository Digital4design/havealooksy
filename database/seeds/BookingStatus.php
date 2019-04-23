<?php

use Illuminate\Database\Seeder;

class BookingStatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('booking_status')->delete();
        	$bookingStatusData = array(
        		array(
        			'id' => 1,
        			'name' => 'pending',
        			'description' =>  'When the booking is confirmed by Host but payment is pending.',
        			'created_at' =>  date("Y-m-d H:i:s"),
        			'updated_at' =>  date("Y-m-d H:i:s"),
        		),
        		array(
        			'id' =>2,
        			'name' => 'reserved',
        			'description' => 'When booking is confirmed with payment.',
        			'created_at' =>  date("Y-m-d H:i:s"),
        			'updated_at' =>  date("Y-m-d H:i:s"),
        		),
        		array(
        			'id' =>3,
        			'name' => 'waiting',
        			'description' => 'When booking is not confirmed by Host.',
        			'created_at' =>  date("Y-m-d H:i:s"),
        			'updated_at' =>  date("Y-m-d H:i:s"),
        		),
        		array(
        			'id' =>4,
        			'name' => 'cancelled',
        			'description' => 'When booking is cancelled by Host.',
        			'created_at' =>  date("Y-m-d H:i:s"),
        			'updated_at' =>  date("Y-m-d H:i:s"),
        		),
        	);
        	DB::table('booking_status')->insert($bookingStatusData);
    }
}
