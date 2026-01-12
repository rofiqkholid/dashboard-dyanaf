<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvOrder extends Model
{
    use HasFactory;

    protected $table = 'cv_orders';
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class, 'transaction_id', 'order_id');
    }
}
