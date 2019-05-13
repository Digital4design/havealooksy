<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    protected $fillable = ['order_id', 'transaction_id', 'amount', 'invoice_date', 'user_id'];
}
