<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';

    protected $allowedFields = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'gambar',
        'is_active'
    ];

    /** 
     * Ambil semua produk aktif
     */
    public function getAllProducts()
    {
        return $this->where('is_active', 1)->findAll();
    }

    /**
     * Ambil produk berdasarkan kategori
     */
    public function getProductsByCategory($category_id)
    {
        return $this->where('category_id', $category_id)
                    ->where('is_active', 1)
                    ->findAll();
    }

    /**
     * Ambil 1 produk berdasarkan ID
     */
    public function getProduct($id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * JOIN Kategori (untuk tampilan halaman kategori & detail)
     */
    public function getProductsWithCategory()
    {
        return $this->select('products.*, categories.name AS category_name')
                    ->join('categories', 'categories.id = products.category_id')
                    ->where('products.is_active', 1)
                    ->findAll();
    }

    /**
     * Detail produk + kategori
     */
    public function getProductDetail($id)
    {
        return $this->select('products.*, categories.name AS category_name')
                    ->join('categories', 'categories.id = products.category_id')
                    ->where('products.id', $id)
                    ->first();
    }

        /**
     * Produk terkait berdasarkan kategori (untuk bagian "Produk Lainnya")
     */
    public function getRelatedProducts($category_id, $except_id, $limit = 3)
    {
        return $this->where('category_id', $category_id)
                    ->where('id !=', $except_id)
                    ->where('is_active', 1)
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Fitur pencarian produk (optional untuk frontend menu)
     */
    public function searchProducts($keyword)
    {
        return $this->groupStart()
                        ->like('name', $keyword)
                        ->orLike('description', $keyword)
                    ->groupEnd()
                    ->where('is_active', 1)
                    ->findAll();
    }

    /**
     * Hitung total produk aktif
     */
    public function countActiveProducts()
    {
        return $this->where('is_active', 1)->countAllResults();
    }
}



