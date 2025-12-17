<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReviewModel;
use App\Models\ProductsModel;

class ReviewController extends BaseController
{
    protected $reviewModel;
    protected $productModel;

    public function __construct()
    {
        $this->reviewModel  = new ReviewModel();
        $this->productModel = new ProductsModel();
    }

    public function index($productId)
    {
        $product = $this->productModel->find($productId);

        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        return view('review_form', [
            'productId' => $productId,
            'product'   => $product
        ]);
    }

    public function save()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $data = [
            'product_id'  => $this->request->getPost('product_id'),
            'user_id'     => session()->get('user_id'),
            'rating'      => $this->request->getPost('rating'),
            'comment'     => $this->request->getPost('comment'),
            'is_approved' => 0, // menunggu approval admin
            'created_at'  => date('Y-m-d H:i:s')
        ];

        $this->reviewModel->insert($data);

        return redirect()->to('/histori')
            ->with('success', 'Review berhasil ditambahkan!');
    }

    public function adminIndex()
    {
        $data['reviews'] = $this->reviewModel->getAllWithProductUser();
        return view('admin/review/index', $data);
    }
}
