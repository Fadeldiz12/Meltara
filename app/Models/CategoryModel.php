<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name'
    ];

    protected $useTimestamps = false;

    // Ambil semua kategori (otomatis sorted agar rapi)
    public function getAllCategories()
    {
        return $this->orderBy('name', 'ASC')->findAll();
    }

    // Ambil kategori berdasarkan ID
    public function getCategory($id)
    {
        return $this->find($id);
    }

        /**
     * Hitung jumlah produk dalam kategori tertentu
     */
    public function getCategoryProductsCount($category_id)
    {
        return db_connect()
                ->table('products')
                ->where('category_id', $category_id)
                ->where('is_active', 1)
                ->countAllResults();
    }
}


