<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductsModel;
use App\Models\CategoryModel;

class AdminProduct extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductsModel();
        $this->categoryModel = new CategoryModel();
    }

    // ========================= LIST PRODUK =========================
    public function index()
    {
        return view('admin/admin_product', [
            'title' => 'Product Management',
            'products' => $this->productModel->getProductsWithCategory()
        ]);
    }

    // ========================= TAMPILKAN FORM TAMBAH =========================
    public function add()
    {
        return view('admin/product_add', [
            'title' => 'Add Product',
            'categories' => $this->categoryModel->getAllCategories()
        ]);
    }

    // ========================= SIMPAN PRODUK BARU =========================
    public function store()
    {
        $gambar = $this->request->getFile('gambar');

        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move('uploads/products', $newName);
        } else {
            $newName = null;
        }

        $this->productModel->save([
            'category_id' => $this->request->getPost('category_id'),
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'gambar'      => $newName,
            'is_active'   => 1
        ]);

        return redirect()->to('/admin/products')->with('success', 'Produk berhasil ditambahkan');
    }

    // ========================= HAPUS PRODUK =========================
    public function delete($id)
    {
        $this->productModel->delete($id);
        return redirect()->to('/admin/products')->with('success', 'Produk berhasil dihapus');
    }

    public function edit($id)
{
    $productModel  = new \App\Models\ProductsModel();
    $categoryModel = new \App\Models\CategoryModel();

    $data = [
        'title'      => 'Edit Produk',
        'product'    => $productModel->find($id),
        'categories' => $categoryModel->findAll(),
    ];

    return view('admin/product_edit', $data);
}


public function update($id)
{
    $productModel = new \App\Models\ProductsModel();

    $data = [
        'name'        => $this->request->getPost('name'),
        'category_id' => $this->request->getPost('category_id'),
        'price'       => $this->request->getPost('price'),
        'stock'       => $this->request->getPost('stock'),
        'description' => $this->request->getPost('description'),
    ];

    $gambar = $this->request->getFile('gambar');
    if ($gambar && $gambar->isValid()) {
        $newName = $gambar->getRandomName();
        $gambar->move('uploads/products', $newName);
        $data['gambar'] = $newName;
    }

    $productModel->update($id, $data);

    return redirect()->to('/admin/products')->with('success', 'Produk berhasil diperbarui!');
}

}
