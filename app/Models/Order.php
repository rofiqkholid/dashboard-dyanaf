<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_name',
    ];

    public function cvOrder()
    {
        // Order -> Transaction (via order_id) -> CvOrder (via transaction.id = cv_orders.transaction_id)
        return $this->hasOneThrough(
            CvOrder::class,          // Final model
            Transaction::class,      // Intermediate model
            'order_id',              // Foreign key on transactions (matches orders.order_id)
            'transaction_id',        // Foreign key on cv_orders (matches transactions.id)
            'order_id',              // Local key on orders
            'id'                     // Local key on transactions (cv_orders.transaction_id references this)
        );
    }
}
