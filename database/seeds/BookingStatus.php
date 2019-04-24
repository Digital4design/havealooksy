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
                    'display_name' => 'Pending',
        			'description' =>  'When the booking is confirmed by Host but payment is pending.',
        			'created_at' =>  date("Y-m-d H:i:s"),
        			'updated_at' =>  date("Y-m-d H:i:s"),
        		),
        		array(
        			'id' =>2,
        			'name' => 'reserved',
                    'display_name' => 'Reserved',
        			'description' => 'When booking is confirmed with payment.',
        			'created_at' =>  date("Y-m-d H:i:s"),
        			'updated_at' =>  date("Y-m-d H:i:s"),
        		),
        		array(
        			'id' =>3,
        			'name' => 'waiting',
                    'display_name' => 'Waiting for Confirmation',
        			'description' => 'When booking is not confirmed by Host.',
        			'created_at' =>  date("Y-m-d H:i:s"),
        			'updated_at' =>  date("Y-m-d H:i:s"),
        		),
        		array(
        			'id' =>4,
        			'name' => 'cancelled',
                    'display_name' => 'Cancelled',
        			'description' => 'When booking is cancelled by Host.',
        			'created_at' =>  date("Y-m-d H:i:s"),
        			'updated_at' =>  date("Y-m-d H:i:s"),
        		),
        	);
        	DB::table('booking_status')->insert($bookingStatusData);
    }
}
