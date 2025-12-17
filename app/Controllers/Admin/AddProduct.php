<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AddProduct extends BaseController
{
    public function addProduct()
    {
        $data = [
            'title' => 'Tambah Produk'
        ];

        return view('admin/product_add', $data);
    }
}
