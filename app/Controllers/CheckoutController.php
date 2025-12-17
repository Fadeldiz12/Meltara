<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ShippingInfoModel;

class CheckoutController extends BaseController
{
    // ======================
    // CHECKOUT PAGE
    // ======================
    public function index()
    {
        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/cart')->with('error', 'Keranjang masih kosong!');
        }

        // ✅ HITUNG SUBTOTAL (TANPA SHIPPING)
        $subtotal = array_sum(array_map(function ($item) {
            return $item['price'] * $item['qty'];
        }, $cart));

        $total = $subtotal; // 🔥 TANPA SHIPPING

        return view('checkout', [
            'cart'     => $cart,
            'subtotal' => $subtotal,
            'total'    => $total
        ]);
    }

    // ======================
    // PROCESS CHECKOUT
    // ======================
    public function process()
    {
        $cart = session()->get('cart') ?? [];
        if (empty($cart)) return redirect()->to('/cart');

        $payment = $this->request->getPost('payment_method');

        // ✅ HITUNG SUBTOTAL (TANPA SHIPPING)
        $subtotal = array_sum(array_map(function ($item) {
            return $item['price'] * $item['qty'];
        }, $cart));

        $total = $subtotal; // 🔥 TANPA SHIPPING

        $orderModel = new OrderModel();
        $itemModel  = new OrderItemModel();
        $shipModel  = new ShippingInfoModel();

        $paymentStatus = ($payment === 'QRIS') ? 'Pending' : 'Success';
        $statusOrder   = ($payment === 'QRIS') ? 'Pending' : 'Dikemas';

        // ======================
        // INSERT ORDER (NO SHIPPING FIELD)
        // ======================
        $orderID = $orderModel->insert([
            'order_number'   => 'ORD' . time(),
            'user_id'        => session()->get('user_id'),
            'order_date'     => date('Y-m-d H:i:s'),
            'subtotal'       => $subtotal,
            'total_amount'   => $total,
            'status'         => $statusOrder,
            'payment_method' => $payment,
            'payment_status' => $paymentStatus
        ]);

        // ======================
        // INSERT ORDER ITEMS
        // ======================
        foreach ($cart as $item) {
            $itemModel->insert([
                'order_id'   => $orderID,
                'product_id' => $item['id'],
                'quantity'   => $item['qty'],
                'unit_price' => $item['price'],
                'subtotal'   => $item['price'] * $item['qty']
            ]);
        }

        // ======================
        // INSERT SHIPPING INFO (DATA ALAMAT SAJA)
        // ======================
        $shipModel->insert([
            'order_id'        => $orderID,
            'recipient'       => $this->request->getPost('recipient'),
            'address'         => $this->request->getPost('address'),
            'phone'           => $this->request->getPost('phone'),
            'delivery_status' => 'Dikemas'
        ]);

        // ======================
        // UPLOAD BUKTI QRIS
        // ======================
        if ($payment === 'QRIS') {
            $file = $this->request->getFile('payment_proof');
            if ($file && $file->isValid()) {
                $name = $file->getRandomName();
                $file->move('uploads/proofs', $name);
                $orderModel->update($orderID, ['payment_proof' => $name]);
            }
        }

        session()->remove('cart');
        return redirect()->to('/order_detail/' . $orderID);
    }

    // ======================
    // ORDER DETAIL
    // ======================
    public function detail($orderID)
    {
        $orderModel = new OrderModel();
        $itemModel  = new OrderItemModel();
        $shipModel  = new ShippingInfoModel();

        $order = $orderModel->find($orderID);
        if (!$order) return redirect()->back();

        $items = $itemModel
            ->select('order_items.*, products.name AS product_name')
            ->join('products', 'products.id = order_items.product_id')
            ->where('order_items.order_id', $orderID)
            ->findAll();

        // ✅ TOTAL = JUMLAH ITEM (TANPA SHIPPING)
        $total = array_sum(array_column($items, 'subtotal'));

        $shipping = $shipModel->where('order_id', $orderID)->first();

        return view('order_detail', [
            'order' => $order,
            'items' => $items,
            'total' => $total,
            'shipping' => $shipping // hanya alamat & status
        ]);
    }
}
