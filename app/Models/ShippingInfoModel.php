<?php
namespace App\Models;
use CodeIgniter\Model;

class ShippingInfoModel extends Model {
    protected $table = 'shipping_info';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'order_id','recipient','address','phone','delivery_status'
    ];
}