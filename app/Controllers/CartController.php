<?php

namespace App\Controllers;
use App\Models\ProductsModel;
use CodeIgniter\Controller; 

class CartController extends BaseController
{
    // Halaman Keranjang - TELAH DIPERBARUI
    public function index()
    {
        $cart = session()->get('cart') ?? [];
        
        // Perubahan di sini: Mengarahkan ke file view yang baru
        return view('halaman_keranjang', ['cart' => $cart]); 
    }

    // Menambahkan Produk ke Keranjang (TIDAK BERUBAH)
    public function add()
    {
        $session = session();
        $productId = $this->request->getPost('product_id');
        $qty = (int) $this->request->getPost('qty');

        if ($qty < 1) $qty = 1;

        $productModel = new ProductsModel();
        $product = $productModel->find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $cart = $session->get('cart') ?? [];

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] += $qty;
        } else {
            $cart[$productId] = [
                'id'        => $product['id'],
                'name'      => $product['name'],
                'price'     => $product['price'],
                'gambar'    => $product['gambar'],
                'qty'       => $qty
            ];
        }

        $session->set('cart', $cart);

        // Balik lagi ke halaman detail saja
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }


    // Mengubah Quantity (+ atau -) (TIDAK BERUBAH)
    public function update()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        $productId = $this->request->getPost('id');
        $action    = $this->request->getPost('action');

        if (isset($cart[$productId])) {
            if ($action == "plus") {
                $cart[$productId]['qty']++;
            }
            if ($action == "minus" && $cart[$productId]['qty'] > 1) {
                $cart[$productId]['qty']--;
            }
        }

        $session->set('cart', $cart);
        return redirect()->to('/cart');
    }

    // Menghapus Item dari Keranjang (TIDAK BERUBAH)
    public function remove()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        $productId = $this->request->getPost('id');

        if(isset($cart[$productId])){
            unset($cart[$productId]);
        }

        $session->set('cart', $cart);
        return redirect()->to('/cart');
    }
}