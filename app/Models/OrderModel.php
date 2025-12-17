<?php
namespace App\Models;
use CodeIgniter\Model;

class OrderModel extends Model {
    protected $table = 'orders';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'order_number','user_id','order_date',
        'subtotal','shipping_cost','total_amount',
        'status','payment_method',
        'payment_proof',    // ✅ BARU
        'payment_status'    // ✅ BARU (Pending, Success, Failed)
    ];
}