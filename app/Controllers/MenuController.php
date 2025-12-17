<?php

namespace App\Controllers;

use App\Models\ProductsModel;
use App\Models\CategoryModel;

class MenuController extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductsModel();
        $this->categoryModel = new CategoryModel();
    }

    // =======================
    //   Halaman Menu Utama
    // =======================
    public function index()
    {
        // baca parameter GET ?category= (jika tidak ada => 'all')
        $categoryParam = $this->request->getGet('category') ?? 'all';

        // tentukan products berdasarkan categoryParam
        if ($categoryParam === 'all' || $categoryParam === '') {
            $products = $this->productModel->getProductsWithCategory();
        } else {
            // jika numeric -> ambil berdasarkan id kategori
            if (is_numeric($categoryParam)) {
                $products = $this->productModel->getProductsByCategory((int)$categoryParam);
            } else {
                // bila param tidak valid -> fallback tampilkan semua
                $products = $this->productModel->getProductsWithCategory();
                $categoryParam = 'all';
            }
        }

        $data = [
            'title'            => 'Menu | Meltara',
            'categories'       => $this->categoryModel->findAll(),
            'products'         => $products,
            // gunakan key ini agar view tahu tombol mana yang aktif
            'selectedCategory' => $categoryParam
        ];

        return view('menu', $data);
    }

    // =======================
    //   Filter Berdasarkan Kategori (opsional route)
    // =======================
    public function kategori($id)
    {
        if (!$this->categoryModel->find($id)) {
            return redirect()->to('/menu')->with('warning', 'Kategori tidak ditemukan!');
        }

        $data = [
            'title'            => 'Menu | Meltara',
            'categories'       => $this->categoryModel->findAll(),
            'products'         => $this->productModel->getProductsByCategory($id),
            'selectedCategory' => (string)$id
        ];

        return view('menu', $data);
    }

    // =======================
    //   Halaman Detail Produk
    // =======================
    public function detail($id)
    {
        $product = $this->productModel->getProductDetail($id);

        if (!$product) {
            return redirect()->to('/menu')->with('error', 'Produk tidak ditemukan!');
        }

        $data = [
            'title'   => 'Detail Produk',
            'product' => $product
        ];

        return view('product_detail', $data);
    }
}
