<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Judson:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/layout.css') ?>">

    <style>
        :root{
            /* PALET UTAMA (Disamakan dengan home.php) */
            --accent:#CEAB93;
            --accent60:rgba(206,171,147,0.60);
            --bg-page:#FFFBE9;
            --sand: #E3CAA5; 
            --sand60:rgba(227,202,165,0.60);
            
            /* Warna baru */
            --color-text: #1c120d;
            --color-dark-brown: #5A4638;
            --color-black-text: #000000;
            --color-light-brown: var(--sand); 
        }

        body{
            margin:0;
            padding:0;
            font-family:"Judson", serif;
            background:white;
            color:var(--color-text);
        }

        /* ===================== PAGE WRAPPER (Diatur mirip home.php) ===================== */
        .page-wrapper{
            max-width:1200px; /* Dibuat sama dengan home.php */
            margin:0 auto 60px auto;
            /* ✅ PERBAIKAN: Padding-top disesuaikan menjadi 100px (lebih besar dari tinggi navbar 80px) */
            padding:100px 40px 40px 40px; 
            /* Dibuat transparan/tanpa background agar rapi di desktop */
            background:transparent; 
            border-radius:16px;
            box-shadow:none;
        }

        /* ===================== PRODUCT DETAIL CONTAINER (Kontainer Utama) ===================== */
        .product-container{
            /* Kontainer ini yang diberikan background dan rata tengah */
            background: var(--bg-page); 
            border-radius: 16px;
            /* Tambahkan padding di dalam kontainer ini */
            padding: 40px; 
            box-shadow: 0 4px 14px rgba(0,0,0,0.06);

            /* Lebar diatur agar konten utama terpusat dan tidak terlalu besar */
            max-width: 900px; 
            margin: 0 auto; /* Rata tengah */
            
            display:flex;
            gap:34px;
            align-items:flex-start;
            flex-wrap:wrap;
            justify-content: center; /* Memastikan rata tengah di dalam max-width */
        }

        .product-img-box{
            /* Lebar gambar utama diperkecil sedikit */
            width:400px; 
            max-width:100%;
            height:auto;
            aspect-ratio: 10/9; 
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-img-box img{
            width:100%;
            height:100%;
            object-fit:cover; 
            border-radius:14px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .product-info{
            /* Lebar informasi produk dibuat tetap/maksimal agar seimbang dengan gambar */
            width: 400px;
            max-width: 100%;
            min-width:300px; 
        }

        .product-info h1{
            margin:0;
            font-size:32px;
            font-weight:700;
            color:var(--color-black-text);
        }

        .price{
            font-size:24px;
            margin:16px 0 16px 0;
            font-weight:700;
            color:var(--color-black-text);
        }

        /* ✅ PERBAIKAN CSS: Stok ditampilkan */
        .stock{
            display: block; 
            font-size: 16px;
            margin: 0 0 10px 0;
            color: var(--color-dark-brown);
        }

        .qty-box {
            display: inline-flex; 
            align-items: center;
            margin: 10px 0 0 0; 
            border: 1px solid var(--accent); 
            border-radius: 6px;
            overflow: hidden; 
        }

        .qty-btn {
            padding: 6px 14px; 
            background: var(--accent);
            border: none;
            border-radius: 0; 
            cursor: pointer;
            color: white;
            font-size: 16px;
            font-weight: 700;
            line-height: 1.5; 
        }
        
        #qtyText {
            padding: 6px 14px;
            background-color: white;
            color: var(--color-black-text);
            font-weight: 700;
            font-size: 16px;
        }

        /* Tambahan CSS: Mengganti tampilan tombol ketika dinonaktifkan */
        .qty-btn:disabled, .add-cart:disabled {
            cursor: not-allowed;
            background: #d4d4d4; /* Warna abu-abu saat dinonaktifkan */
            color: #777;
        }

        .add-cart {
            margin-top: 20px; 
            padding: 10px 24px;
            border: none;
            border-radius: 8px; 
            background: var(--accent);
            font-size: 16px;
            color: white;
            cursor: pointer;
            font-weight:700;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
        }

        .desc {
            margin-top: 16px;
            font-size: 16px; 
            line-height: 1.6; 
            max-width: none; 
        }
        
        .desc strong {
            font-weight: 700;
            color: var(--color-black-text);
        }
        
        .desc p {
            margin-bottom: 8px;
            color: var(--color-black-text);
        }


        /* ===================== OTHER PRODUCT (Produk Lainnya) ===================== */

        .other-title{
            margin:70px 0 20px 0; 
            text-align:center; /* Rata tengah untuk judul */
            font-size:24px;
            font-weight:700;
            color:var(--color-black-text);
        }

        .product-grid{
            /* Batasan lebar grid disamakan dengan product-container untuk rata tengah yang sempurna */
            max-width: 900px; 
            margin: 0 auto; 
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); 
            gap:26px;
        }

        .card{
            background:var(--color-light-brown); 
            padding:10px;
            border-radius:14px;
            text-align:center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
        }

        .card img{
            width:100%;
            height:140px; 
            object-fit:cover;
            border-radius:10px;
        }
        
        .card h4 {
            margin: 10px 0 4px 0;
            font-size: 18px;
            font-weight: 700;
            color: var(--color-black-text);
        }
        
        .card p {
            margin: 0 0 10px 0;
            font-size: 16px;
            font-weight: 400; 
            color: var(--color-black-text);
        }
        
        .card button{
            margin-top:0px;
            width:100%;
            padding:10px; 
            background:var(--accent); 
            border:none;
            border-radius:8px;
            font-weight:700;
            cursor:pointer;
            font-size:14px;
            color:white; 
        }

        .card button:hover{
            background:var(--accent60); 
            color:var(--color-black-text);
        }

        /* ===================== RESPONSIVE ===================== */
        @media(max-width:992px){
            .page-wrapper{
                /* ✅ PERBAIKAN: Padding-top disesuaikan menjadi 100px */
                padding:100px 24px 40px 24px; 
            }
            .product-container{
                max-width: none; 
                margin: 0;
                padding: 30px; /* Padding dikecilkan */
                flex-direction:row; 
                align-items:flex-start;
                flex-wrap:wrap;
            }
            .product-img-box{
                /* Memungkinkan flexbox mengatur lebar di tablet */
                width: unset; 
                flex: 1 1 40%;
                height: auto;
                aspect-ratio: 10/9;
            }
            .product-info{
                /* Memungkinkan flexbox mengatur lebar di tablet */
                width: unset;
                flex: 1 1 50%;
                max-width: 100%;
                text-align:left;
            }
            .other-title{
                text-align:left;
            }
            .product-grid{
                max-width: none; 
                margin: 0;
                grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); 
            }
        }

        @media(max-width:640px){
            .page-wrapper{
                /* ✅ PERBAIKAN: Padding-top disesuaikan menjadi 90px (untuk navbar mobile 78px) */
                padding:90px 16px 34px 16px; 
                margin:0 14px 50px 14px;
            }
            .product-container{
                padding: 20px;
                flex-direction:column;
                align-items:center;
                text-align:center;
                flex: unset; 
            }
            .product-img-box{
                flex: unset; 
                width: 100%;
                max-width: 350px; 
            }
            .product-info{
                flex: unset;
                text-align:center;
            }
            .qty-box {
                margin-left: auto;
                margin-right: auto;
            }
            form {
                text-align: center;
            }
            .product-grid{
                grid-template-columns:1fr; 
                max-width: 350px; 
                margin: 0 auto;
            }
            .other-title{
                text-align:center; 
            }
        }

        @media(max-width:412px){
            .page-wrapper{
                /* ✅ PERBAIKAN: Padding-top disesuaikan menjadi 90px */
                padding:90px 12px 30px 12px;
                margin:0 10px 40px 10px;
            }
        }
    </style>
</head>
<body>

<?= $this->include('layout/navbar') ?>

<div class="page-wrapper">

    <?php 
    $filename   = $product['gambar'];
    $uploadDir = FCPATH . 'uploads/products/';
    $baseImg   = base_url('uploads/products');
    $imgUrl    = base_url('uploads/default.png');

    // ✅ Ambil nilai stok produk
    $maxStock = (int)$product['stock']; 

    if (filter_var($filename, FILTER_VALIDATE_URL)) {
        $imgUrl = $filename;
    } elseif (is_file($uploadDir . $filename)) {
        $imgUrl = $baseImg . '/' . $filename;
    }
    ?>

    <div class="product-container">
        <div class="product-img-box">
            <img src="<?= $imgUrl ?>" alt="<?= $product['name'] ?>">
        </div>

        <div class="product-info">
            <h1><?= $product['name'] ?></h1>
            <div class="price">Rp. <?= number_format($product['price'], 0, ',', '.') ?></div>
            
            <div class="stock">
                Stok: 
                <?php if ($maxStock > 0): ?>
                    <b><?= $maxStock ?></b> tersisa
                <?php else: ?>
                    <b style="color: red;">Habis (Out of Stock)</b>
                <?php endif; ?>
            </div>

            <div class="qty-box">
                <button type="button" class="qty-btn" id="minusBtn" <?= $maxStock > 0 ? '' : 'disabled' ?>>−</button>
                <span id="qtyText"><?= $maxStock > 0 ? 1 : 0 ?></span>
                <button type="button" class="qty-btn" id="plusBtn" <?= $maxStock > 0 ? '' : 'disabled' ?>>+</button>
            </div>

            <form action="<?= base_url('cart/add') ?>" method="post">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="qty" id="qtyInput" value="<?= $maxStock > 0 ? 1 : 0 ?>">
                <button type="submit" class="add-cart" id="addToCartBtn" <?= $maxStock > 0 ? '' : 'disabled' ?>>Add to Cart</button>
            </form>

            <div class="desc">
                <?= nl2br($product['description']) ?>
            </div>
        </div>
    </div>

    <h2 class="other-title">Produk Lainnya</h2>

    <div class="product-grid">
        <?php
        $db = \Config\Database::connect();
        $other = $db->table('products')->where('is_active',1)->limit(3)->get()->getResultArray();
        foreach($other as $item): 
            $fname = $item['gambar'];
            $img2  = base_url('uploads/default.png');
            if(filter_var($fname, FILTER_VALIDATE_URL)){
                $img2 = $fname;
            } elseif(is_file(FCPATH.'uploads/products/'.$fname)){
                $img2 = base_url('uploads/products/'.$fname);
            }
        ?>
            <div class="card">
                <img src="<?= $img2 ?>">
                <h4><?= $item['name'] ?></h4>
                <p>Rp. <?= number_format($item['price'],0,',','.') ?></p>
                <button onclick="window.location.href='<?= base_url('product/'.$item['id']) ?>'">
                    View Details
                </button>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<?= $this->include('layout/footer') ?>

<script>
// ✅ Ambil nilai stok maksimal dari PHP
const maxStock = parseInt(<?= $maxStock ?>);

// QTY awal disesuaikan dengan stok. Jika stok 0, QTY awal harus 0.
let qty = maxStock > 0 ? 1 : 0; 
const qtyText  = document.getElementById("qtyText");
const qtyInput = document.getElementById("qtyInput");
const minusBtn = document.getElementById("minusBtn");
const plusBtn  = document.getElementById("plusBtn");
const addToCartBtn = document.getElementById("addToCartBtn");


// Fungsi untuk memperbarui status tombol
function updateButtons() {
    // Tombol Plus dinonaktifkan jika QTY sama dengan stok maksimal atau stok habis
    plusBtn.disabled = qty >= maxStock || maxStock === 0;
    
    // Tombol Minus dinonaktifkan jika QTY sama dengan 1 atau stok habis
    minusBtn.disabled = qty <= 1 || maxStock === 0;
    
    // Tombol Add to Cart dinonaktifkan jika stok habis
    addToCartBtn.disabled = maxStock === 0 || qty < 1;
}

// Inisialisasi tombol saat halaman dimuat
updateButtons();


document.getElementById("minusBtn").onclick = () => {
    // Mengecek agar kuantitas tidak kurang dari 1
    if (qty > 1) { 
        qty--; 
        qtyText.textContent = qty; 
        qtyInput.value = qty;
        updateButtons();
    }
};

document.getElementById("plusBtn").onclick = () => {
    // ✅ Membatasi agar kuantitas tidak melebihi stok maksimal
    if (qty < maxStock) {
        qty++; 
        qtyText.textContent = qty; 
        qtyInput.value = qty;
        updateButtons();
    }
};
</script>

</body>
</html>