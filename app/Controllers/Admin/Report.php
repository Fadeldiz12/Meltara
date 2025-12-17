<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductsModel;
use App\Models\CategoryModel;
use CodeIgniter\HTTP\ResponseInterface;

class Report extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $productModel;
    protected $categoryModel;
    protected $db;

    public function __construct()
    {
        $this->orderModel     = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->productModel   = new ProductsModel();
        $this->categoryModel  = new CategoryModel();
        $this->db             = \Config\Database::connect();
    }

    public function index()
    {
        // Ambil filter dari query string
        $start = $this->request->getGet('start') ?? date('Y-m-d', strtotime('-30 days'));
        $end   = $this->request->getGet('end')   ?? date('Y-m-d');

        // optional kategori filter
        $categoryId = (int) ($this->request->getGet('category') ?? 0);

        // Pastikan format date untuk query (awal dan akhir hari)
        $startDate = date('Y-m-d 00:00:00', strtotime($start));
        $endDate   = date('Y-m-d 23:59:59', strtotime($end));

        // 1) Total pendapatan & total order
        $totalsQ = $this->db->table('orders')
            ->select('COUNT(*) AS total_orders, IFNULL(SUM(total_amount),0) AS total_revenue')
            ->where('order_date >=', $startDate)
            ->where('order_date <=', $endDate);

        if ($categoryId) {
            $totalsQ->join('order_items', 'order_items.order_id = orders.id', 'left')
                    ->join('products', 'products.id = order_items.product_id', 'left')
                    ->where('products.category_id', $categoryId);
        }

        $totals = $totalsQ->get()->getRowArray();

        $totalOrders   = (int) ($totals['total_orders'] ?? 0);
        $totalRevenue  = (float) ($totals['total_revenue'] ?? 0.0);
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders) : 0;

        // 2) Top product (by qty sold) dalam periode
        $topProductQ = $this->db->table('order_items')
            ->select('order_items.product_id, products.name AS product_name, SUM(order_items.quantity) AS total_qty, SUM(order_items.subtotal) AS revenue')
            ->join('products', 'products.id = order_items.product_id', 'left')
            ->join('orders', 'orders.id = order_items.order_id', 'left')
            ->where('orders.order_date >=', $startDate)
            ->where('orders.order_date <=', $endDate)
            ->groupBy('order_items.product_id')
            ->orderBy('total_qty', 'DESC')
            ->limit(1);

        if ($categoryId) $topProductQ->where('products.category_id', $categoryId);
        $topProduct = $topProductQ->get()->getRowArray();

        // 3) Performa per kategori (revenue)
        $catQ = $this->db->table('order_items')
            ->select('products.category_id, categories.name AS category_name, SUM(order_items.subtotal) AS revenue')
            ->join('products', 'products.id = order_items.product_id', 'left')
            ->join('orders', 'orders.id = order_items.order_id', 'left')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('orders.order_date >=', $startDate)
            ->where('orders.order_date <=', $endDate)
            ->groupBy('products.category_id')
            ->orderBy('revenue', 'DESC');

        $catRows = $catQ->get()->getResultArray();

        // 4) Trend penjualan (daily revenue)
        $trendQ = $this->db->table('orders')
            ->select("DATE(order_date) AS day, IFNULL(SUM(total_amount),0) AS revenue")
            ->where('order_date >=', $startDate)
            ->where('order_date <=', $endDate)
            ->groupBy('day')
            ->orderBy('day', 'ASC');

        $trendRows = $trendQ->get()->getResultArray();

        // Build daily labels for full range (fill gaps)
        $labels = [];
        $dataRevenue = [];
        $periodStart = new \DateTime($start);
        $periodEnd = new \DateTime($end);
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($periodStart, $interval, $periodEnd->modify('+1 day'));

        // Map trendRows by date
        $trendMap = [];
        foreach ($trendRows as $r) {
            $trendMap[$r['day']] = (float)$r['revenue'];
        }

        foreach ($period as $dt) {
            $d = $dt->format('Y-m-d');
            $labels[] = $d;
            $dataRevenue[] = isset($trendMap[$d]) ? (float)$trendMap[$d] : 0;
        }

        // 5) Produk: list produk terjual dengan qty, sisa stok, kontribusi revenue
        $prodQ = $this->db->table('products')
            ->select('products.id, products.name, products.gambar, IFNULL(SUM(order_items.quantity),0) AS qty_sold, products.stock, IFNULL(SUM(order_items.subtotal),0) AS revenue')
            ->join('order_items', 'order_items.product_id = products.id', 'left')
            ->join('orders', 'orders.id = order_items.order_id', 'left')
            ->where('orders.order_date >=', $startDate)
            ->where('orders.order_date <=', $endDate)
            ->groupBy('products.id')
            ->orderBy('qty_sold', 'DESC');

        if ($categoryId) $prodQ->where('products.category_id', $categoryId);
        $productRows = $prodQ->get()->getResultArray();

        // ------------------ tambahan laporan pelanggan & ulasan & shipping ------------------

        // --- LAPORAN PELANGGAN ---
        // 1) Top customers (total belanja tertinggi dalam periode)
        $topCustQ = $this->db->table('orders')
            ->select('orders.user_id, COALESCE(users.username, CONCAT("User",orders.user_id)) AS username, IFNULL(SUM(orders.total_amount),0) AS total_spent')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->where('orders.order_date >=', $startDate)
            ->where('orders.order_date <=', $endDate)
            ->groupBy('orders.user_id')
            ->orderBy('total_spent', 'DESC')
            ->limit(5);

        $topCustomers = $topCustQ->get()->getResultArray();

        // 2) New customers (first order date within periode)
        $sql = "
            SELECT o.user_id, COALESCE(u.username, CONCAT('User', o.user_id)) AS username, MIN(o.order_date) AS first_order
            FROM orders o
            LEFT JOIN users u ON u.id = o.user_id
            GROUP BY o.user_id
            HAVING DATE(first_order) BETWEEN ? AND ?
            ORDER BY first_order DESC
            LIMIT 5
        ";
        $newCustQ = $this->db->query($sql, [$start, $end]);
        $newCustomers = $newCustQ->getResultArray();

        // 3) Returning customers (user with >=2 orders in periode) - show top by count
        $returningQ = $this->db->table('orders')
            ->select('orders.user_id, COALESCE(users.username, CONCAT("User",orders.user_id)) AS username, COUNT(orders.id) AS orders_count')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->where('orders.order_date >=', $startDate)
            ->where('orders.order_date <=', $endDate)
            ->groupBy('orders.user_id')
            ->having('orders_count >', 1)
            ->orderBy('orders_count', 'DESC')
            ->limit(5);

        $returningCustomers = $returningQ->get()->getResultArray();

        // --- STATISTIK ULASAN PRODUK ---
        $reviewStatsQ = $this->db->table('reviews')
            ->select('IFNULL(AVG(rating),0) AS avg_rating, COUNT(id) AS total_reviews')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDate)
            ->get()
            ->getRowArray();

        $avgRating = round(floatval($reviewStatsQ['avg_rating']), 1);
        $totalReviews = (int) $reviewStatsQ['total_reviews'];

        // distribution 1-5
        $dist = [];
        for ($r = 1; $r <= 5; $r++) {
            $cnt = $this->db->table('reviews')
                ->select('COUNT(id) AS cnt')
                ->where('rating', $r)
                ->where('created_at >=', $startDate)
                ->where('created_at <=', $endDate)
                ->get()
                ->getRowArray();
            $dist[$r] = (int) ($cnt['cnt'] ?? 0);
        }

        // products with most reviews
        $topReviewedQ = $this->db->table('reviews')
            ->select('reviews.product_id, products.name AS product_name, COUNT(reviews.id) AS review_count')
            ->join('products', 'products.id = reviews.product_id', 'left')
            ->where('reviews.created_at >=', $startDate)
            ->where('reviews.created_at <=', $endDate)
            ->groupBy('reviews.product_id')
            ->orderBy('review_count', 'DESC')
            ->limit(5);

        $topReviewedProducts = $topReviewedQ->get()->getResultArray();

        // --- RINGKASAN PENGIRIMAN ---
        $shipQ = $this->db->table('orders')
            ->select('IFNULL(SUM(shipping_cost),0) AS total_shipping, SUM(CASE WHEN shipping_cost = 0 THEN 1 ELSE 0 END) AS free_shipping_count, COUNT(*) AS orders_count')
            ->where('order_date >=', $startDate)
            ->where('order_date <=', $endDate)
            ->get()
            ->getRowArray();

        $totalShipping = (float) ($shipQ['total_shipping'] ?? 0);
        $freeShippingCount = (int) ($shipQ['free_shipping_count'] ?? 0);

        // Ambil semua kategori untuk dropdown
        $categories = $this->categoryModel->getAllCategories();

        // Data siap dikirim ke view
        return view('admin/report_index', [
            'pageTitle' => 'Laporan & Statistik',
            'activeMenu' => 'reports',
            'start' => date('Y-m-d', strtotime($startDate)),
            'end'   => date('Y-m-d', strtotime($endDate)),
            'categories' => $categories,
            'selectedCategory' => $categoryId,

            // KPI utama
            'totalOrders' => $totalOrders,
            'totalRevenue' => round($totalRevenue),
            'avgOrderValue' => round($avgOrderValue),
            'topProduct' => $topProduct,

            // charts & lists
            'catRows' => $catRows,
            'trendLabels' => $labels,
            'trendData' => $dataRevenue,
            'productRows' => $productRows,

            // laporan pelanggan & ulasan & shipping
            'topCustomers' => $topCustomers,
            'newCustomers' => $newCustomers,
            'returningCustomers' => $returningCustomers,
            'avgRating' => $avgRating,
            'totalReviews' => $totalReviews,
            'reviewDist' => $dist,
            'topReviewedProducts' => $topReviewedProducts,
            'totalShipping' => round($totalShipping),
            'freeShippingCount' => $freeShippingCount,
        ]);
    }

    /**
     * Export ke PDF: pakai Dompdf jika terpasang, kalau tidak fallback ke HTML downloadable.
     */
    public function exportPdf()
    {
        $start = $this->request->getGet('start') ?? date('Y-m-d', strtotime('-30 days'));
        $end   = $this->request->getGet('end')   ?? date('Y-m-d');
        $categoryId = (int) ($this->request->getGet('category') ?? 0);

        $startDate = date('Y-m-d 00:00:00', strtotime($start));
        $endDate   = date('Y-m-d 23:59:59', strtotime($end));

        // ambil ringkasan dan produk (sama seperti index)
        $totals = $this->db->table('orders')
            ->select('COUNT(*) AS total_orders, IFNULL(SUM(total_amount),0) AS total_revenue')
            ->where('order_date >=', $startDate)
            ->where('order_date <=', $endDate)
            ->get()->getRowArray();

        $totalOrders = (int) ($totals['total_orders'] ?? 0);
        $totalRevenue = (float) ($totals['total_revenue'] ?? 0);

        $prodQ = $this->db->table('products')
            ->select('products.id, products.name, IFNULL(SUM(order_items.quantity),0) AS qty_sold, products.stock, IFNULL(SUM(order_items.subtotal),0) AS revenue')
            ->join('order_items', 'order_items.product_id = products.id', 'left')
            ->join('orders', 'orders.id = order_items.order_id', 'left')
            ->where('orders.order_date >=', $startDate)
            ->where('orders.order_date <=', $endDate)
            ->groupBy('products.id')
            ->orderBy('qty_sold', 'DESC');

        if ($categoryId) $prodQ->where('products.category_id', $categoryId);

        $products = $prodQ->get()->getResultArray();

        $html = view('admin/report_pdf_template', [
            'start' => $start,
            'end' => $end,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'products' => $products
        ]);

        // kalau Dompdf tersedia, render PDF
        if (class_exists('\Dompdf\Dompdf')) {
            $options = new \Dompdf\Options();
            $options->set('isRemoteEnabled', true);
            $options->set('chroot', realpath(FCPATH));
            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdfOutput = $dompdf->output();

            return $this->response
                        ->setHeader('Content-Type', 'application/pdf')
                        ->setHeader('Content-Disposition', 'attachment; filename="laporan_' . date('Ymd_His') . '.pdf"')
                        ->setBody($pdfOutput);
        }

        // fallback: kirim HTML sebagai file .html agar bisa disimpan/print
        $filename = 'laporan_' . date('Ymd_His') . '.html';
        return $this->response
                    ->setHeader('Content-Type', 'text/html; charset=utf-8')
                    ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->setBody($html);
    }
}
