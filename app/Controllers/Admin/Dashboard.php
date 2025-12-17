<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Database;

class Dashboard extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index2()
    {
        $data = [];

        // =========================
        // 1. KARTU STATISTIK ATAS
        // =========================

        // Total produk aktif
        $data['totalProducts'] = $this->db->table('products')
            ->where('is_active', 1)
            ->countAllResults();

        // Total pesanan & total pendapatan (bulan ini, status completed)
        $builder = $this->db->table('orders');
        $builder->select('COUNT(*) AS total_orders, COALESCE(SUM(total_amount), 0) AS total_revenue', false);
        $builder->where('status', 'completed');
        $builder->where('MONTH(order_date)', date('m'));
        $builder->where('YEAR(order_date)', date('Y'));

        $row = $builder->get()->getRow();
        $data['totalOrders']  = $row ? (int) $row->total_orders : 0;
        $data['totalRevenue'] = $row ? (float) $row->total_revenue : 0;

        // Pesanan menunggu (status pending)
        $data['pendingOrders'] = $this->db->table('orders')
            ->where('status', 'pending')
            ->countAllResults();

        // Rating produk rata-rata (hanya review yang disetujui)
        $avgRatingRow = $this->db->table('reviews')
            ->select('AVG(rating) AS avg_rating')
            ->where('is_approved', 1)
            ->get()
            ->getRow();
        $data['avgRating'] = $avgRatingRow ? round($avgRatingRow->avg_rating, 1) : 0;

        // Produk habis stok
        $data['outOfStock'] = $this->db->table('products')
            ->where('stock <=', 0)
            ->countAllResults();

        // ====================================
        // 2. GRAFIK PENJUALAN 30 HARI TERAKHIR
        // ====================================
        $salesRows = $this->db->table('orders')
            ->select('DATE(order_date) AS tanggal, COALESCE(SUM(total_amount), 0) AS total', false)
            ->where('order_date >=', date('Y-m-d', strtotime('-30 days')))
            ->where('status', 'completed')
            ->groupBy('DATE(order_date)')
            ->orderBy('tanggal', 'ASC')
            ->get()
            ->getResultArray();

        $salesLabels = [];
        $salesData   = [];
        foreach ($salesRows as $row) {
            $salesLabels[] = $row['tanggal'];
            $salesData[]   = (float) $row['total'];
        }

        $data['salesChart'] = [
            'labels' => $salesLabels,
            'data'   => $salesData,
        ];

        // =================================
        // 3. GRAFIK PENJUALAN PER KATEGORI
        // =================================
        // Di sini yang dihitung jumlah produk terjual per kategori (bukan uang)
        $categoryRows = $this->db->table('order_items oi')
            ->select('c.name AS kategori, COALESCE(SUM(oi.quantity), 0) AS total_qty', false)
            ->join('orders o', 'o.id = oi.order_id', 'left')
            ->join('products p', 'p.id = oi.product_id', 'left')
            ->join('categories c', 'c.id = p.category_id', 'left')
            ->where('o.status', 'completed')
            ->groupBy('c.name')
            ->orderBy('total_qty', 'DESC')
            ->get()
            ->getResultArray();

        $categoryLabels = [];
        $categoryData   = [];
        foreach ($categoryRows as $row) {
            $categoryLabels[] = $row['kategori'] ?? 'Tanpa Kategori';
            $categoryData[]   = (int) $row['total_qty'];
        }

        $data['categoryChart'] = [
            'labels' => $categoryLabels,
            'data'   => $categoryData,
        ];

        // ======================
        // 4. TABEL PESANAN TERBARU
        // ======================
        // Nama pelanggan diambil dari shipping_info.recipient, fallback ke users.username
        $data['recentOrders'] = $this->db->table('orders o')
            ->select("
                o.order_number,
                o.order_date,
                o.total_amount,
                o.status,
                COALESCE(s.recipient, u.username) AS customer_name
            ", false)
            ->join('shipping_info s', 's.order_id = o.id', 'left')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->orderBy('o.order_date', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // ======================
        // 5. PERINGATAN STOK RENDAH
        // ======================
        $data['lowStockProducts'] = $this->db->table('products')
            ->select('name, stock')
            ->where('is_active', 1)
            ->where('stock <=', 10)
            ->orderBy('stock', 'ASC')
            ->limit(4)
            ->get()
            ->getResultArray();

        // ======================
        // 6. ULASAN TERBARU
        // ======================
        $data['latestReviews'] = $this->db->table('reviews r')
            ->select('
                r.rating,
                r.comment,
                r.is_approved,
                u.username AS customer_name,
                p.name AS product_name
            ', false)
            ->join('users u', 'u.id = r.user_id', 'left')
            ->join('products p', 'p.id = r.product_id', 'left')
            ->orderBy('r.created_at', 'DESC')
            ->limit(4)
            ->get()
            ->getResultArray();

        return view('admin/dashboard', $data);
    }
}
