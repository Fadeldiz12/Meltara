<?php

namespace App\Controllers;

use App\Models\ProductsModel;   // ← sudah benar
use App\Models\CategoryModel;

class ProductController extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductsModel();   // ← sudah benar
    }

    public function detail($id)
    {
        $product = $this->productModel->getProductDetail($id);

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produk tidak ditemukan.");
        }

        return view('detail_product', [
            'title'    => $product['name'],
            'product'  => $product
        ]);
    }
}
