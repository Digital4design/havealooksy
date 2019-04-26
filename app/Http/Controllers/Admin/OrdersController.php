<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\OrderItems;
use App\Models\Bookings;
use App\Models\Orders;

class OrdersController extends Controller
{
    public function getOrdersView()
    {
    	return view('admin.orders_view');
    }

    public function getAllOrders()
    {
    	$orders = Orders::with(['getOrderItems'])->get();

    	return Datatables::of($orders)
    					->editColumn('user_id', function ($orders){
                            return "<a href='".url('admin/users/view/'.$orders['user_id'])."' class='view_eye' style='padding:0px 16px;'><i class='fa fa-eye'></i></a>";
    					})->addColumn('order_items', function ($orders){
                            return "<a href='".url('admin/orders/view/'.$orders['id'])."' class='btn btn-info'>View Order Items</a>";
    					})->rawColumns(['user_id' => 'user_id', 'order_items' => 'order_items'])
    					->make(true);
    }

    public function getOrderDetailsView($id)
    {
    	$get_order_items = OrderItems::where('order_id', $id)->get();
    	
    	foreach ($get_order_items as $value)
    	{
    		$order_items = Bookings::with(['getBookedListingUser', 'getBookedListingTime'])->where('id', $value['order_item'])->get();
    	}

    	return view('admin.order_details_view')->with(['order_items' => $order_items]);
    }
}
