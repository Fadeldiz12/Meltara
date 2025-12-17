<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ShippingInfoModel;
use App\Models\ProductsModel;

class OrderController extends BaseController
{
    // ======================
    // LIST PESANAN USER
    // ======================
    public function index()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $orderModel = new OrderModel();
        $userId = session()->get('user_id');

        $orders = $orderModel
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('daftar_pesanan', [
            'orders' => $orders
        ]);
    }

    // ======================
    // DETAIL ORDER USER
    // ======================
    public function detail($orderID)
    {
        $orderModel = new OrderModel();
        $itemModel  = new OrderItemModel();
        $shipModel  = new ShippingInfoModel();

        $order = $orderModel->find($orderID);
        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan');
        }

        // 🔒 Normalisasi status pembayaran
        if (
            ($order['status'] ?? '') !== 'Pending' &&
            ($order['payment_status'] ?? '') === 'Pending'
        ) {
            $order['payment_status'] = 'Success';
        }

        if (empty($order['payment_status'])) {
            $order['payment_status'] =
                (($order['status'] ?? '') !== 'Pending') ? 'Success' : 'Pending';
        }

        // Ambil item order
        $items = $itemModel
            ->select('order_items.*, products.name AS product_name')
            ->join('products', 'products.id = order_items.product_id')
            ->where('order_items.order_id', $orderID)
            ->findAll();

        // ======================
        // HITUNG TOTAL (TANPA SHIPPING)
        // ======================
        $subtotal = 0;
        foreach ($items as $item) {
            // pastikan subtotal ada, fallback ke price * qty
            $subtotal += $item['subtotal']
                ?? ($item['price'] * $item['qty']);
        }

        $total = $subtotal; // ✅ TANPA SHIPPING

        // ======================
        // DATA PENGIRIMAN (ALAMAT SAJA)
        // ======================
        $shipping = $shipModel
            ->where('order_id', $orderID)
            ->first();

        if (!$shipping) {
            $shipping = [
                'recipient' => '-',
                'address' => '-',
                'phone' => '-',
                'delivery_status' => 'Dikemas'
            ];
        }

        return view('order_detail', [
            'order'    => $order,
            'items'    => $items,
            'subtotal' => $subtotal,
            'total'    => $total,
            'shipping' => $shipping // ❗ hanya alamat & status
        ]);
    }

    // ======================
    // UPLOAD BUKTI QRIS
    // ======================
    public function uploadProof($id)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->find($id);

        if (!$order || $order['payment_method'] !== 'QRIS') {
            return redirect()->back()->with('error', 'Order tidak valid');
        }

        $file = $this->request->getFile('payment_proof');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid');
        }

        $name = $file->getRandomName();
        $file->move('uploads/proofs', $name);

        $orderModel->update($id, [
            'payment_proof'  => $name,
            'payment_status' => 'Pending'
        ]);

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload');
    }

    // ======================
    // HISTORY ORDER USER
    // ======================
    public function history()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $orderModel = new OrderModel();
        $itemModel  = new OrderItemModel();
        $userId     = session()->get('user_id');

        $orders = $orderModel
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->findAll();

        foreach ($orders as &$order) {
            $order['items'] = $itemModel
                ->select('order_items.product_id, products.name')
                ->join('products', 'products.id = order_items.product_id')
                ->where('order_items.order_id', $order['id'])
                ->findAll();
        }

        return view('order_history', [
            'orders' => $orders
        ]);
    }
}
