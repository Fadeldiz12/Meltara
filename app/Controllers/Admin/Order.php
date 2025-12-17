<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ShippingInfoModel;

class Order extends BaseController
{
    protected $orderModel;
    protected $shipModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->shipModel  = new ShippingInfoModel();
    }

    public function index()
    {
        $status = $this->request->getGet('status') ?? 'all';

        $query = $this->orderModel
            ->select('orders.*, shipping_info.recipient')
            ->join('shipping_info', 'shipping_info.order_id = orders.id', 'left');

        if ($status !== 'all') {
            $query->where('orders.status', $status);
        }

        $orders = $query->orderBy('orders.id', 'DESC')->findAll();

        return view('admin/orderlist', [
            'orders' => $orders,
            'activeStatus' => $status
        ]);
    }

    public function detail($id)
    {
        $itemModel = new OrderItemModel();

        $order = $this->orderModel->find($id);
        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan');
        }

        // ✅ JAGA-JAGA JIKA NULL
        if (empty($order['payment_status'])) {
            $order['payment_status'] = 'Pending';
        }

        $items = $itemModel
            ->select('order_items.*, products.name AS product_name')
            ->join('products', 'products.id = order_items.product_id')
            ->where('order_id', $id)
            ->findAll();

        $shipping = $this->shipModel->where('order_id', $id)->first();

        return view('admin/orderdetail', [
            'order' => $order,
            'items' => $items,
            'shipping' => $shipping,
            'proofPath' => !empty($order['payment_proof'])
                ? base_url('uploads/proofs/' . $order['payment_proof'])
                : null
        ]);
    }

    // ======================
    // APPROVE PAYMENT
    // ======================
    public function approvePayment($id)
{
    $this->orderModel->update($id, [
        'payment_status' => 'Success',
        'status'         => 'Dikemas'
    ]);

    return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi');
}



    // ======================
    // REJECT PAYMENT
    // ======================
    public function rejectPayment($id)
    {
        $this->orderModel->update($id, [
            'payment_status' => 'Failed',
            'status'         => 'Cancelled'
        ]);

        return redirect()->back()->with('error', 'Pembayaran ditolak');
    }

    // ======================
    // UPDATE DELIVERY STATUS
    // ======================
   // ======================
// UPDATE STATUS PESANAN
// ======================
public function updateOrderStatus($id)
{
    $status = $this->request->getPost('status');
    if (!$status) return redirect()->back();

    $data = ['status' => $status];

    // 🔥 KUNCI UTAMA
    if (in_array($status, ['Dikemas','Dikirim','Selesai'])) {
        $data['payment_status'] = 'Success';
    }

    $this->orderModel->update($id, $data);

    // sync shipping
    if ($status === 'Dikemas') {
        $this->shipModel->where('order_id', $id)
            ->set(['delivery_status' => 'Dikemas'])->update();
    }
    if ($status === 'Dikirim') {
        $this->shipModel->where('order_id', $id)
            ->set(['delivery_status' => 'Dikirim'])->update();
    }
    if ($status === 'Selesai') {
        $this->shipModel->where('order_id', $id)
            ->set(['delivery_status' => 'Sampai'])->update();
    }

    return redirect()->back()->with('success', 'Status pesanan diperbarui');
}



}
