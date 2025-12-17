<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table      = 'reviews';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'product_id',
        'user_id',
        'rating',
        'comment',
        'is_approved',
        'created_at'
    ];

    public $useTimestamps = false;

    // ===============================
    // GET REVIEW + USER + PRODUCT
    // ===============================
    public function getAllWithProductUser()
    {
        return $this->db->table('reviews r')
            ->select('
                r.*,
                u.username AS user_name,
                p.name AS product_name
            ')
            ->join('users u', 'u.id = r.user_id', 'left')
            ->join('products p', 'p.id = r.product_id', 'left')
            ->orderBy('r.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
}
