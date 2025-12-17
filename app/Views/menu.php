<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Menu | Meltara</title>

    <link href="https://fonts.googleapis.com/css2?family=Judson:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/layout.css') ?>">

    <style>
        :root{
            --accent:   #CEAB93;
            --accent60: rgba(206,171,147,0.60);
            --sand:     #E3CAA5;
            --sand60:   rgba(227,202,165,0.60);
            --cream:    #FFFBE9;
            --white:    #FFFFFF;
        }

        *{ box-sizing:border-box; }

        html, body{
            margin:0;
            padding:0;
            overflow-x:hidden;
            font-family:"Judson", serif;
            background:var(--white);
        }

        /* ===================== WRAPPER ===================== */
        .page-wrapper{
            max-width:1150px;
            margin:0 auto 60px auto;
            padding:120px 24px 40px 24px; /* jarak dari navbar */
            background:var(--cream);
            border-radius:16px;
            box-shadow:0 4px 14px rgba(0,0,0,0.06);
        }

        /* ===================== FILTER ===================== */
        .filter-container{
            text-align:center;
            margin-bottom:30px;
        }

        .filter-btn{
            padding:8px 24px;
            border:none;
            background:var(--sand60);
            border-radius:20px;
            font-size:17px;
            font-weight:700;
            margin:0 6px 8px 6px;
            cursor:pointer;
            color:#2b2017;
            box-shadow:0 2px 4px rgba(0,0,0,0.08);
            transition:0.15s ease;
        }

        .filter-btn:hover{
            transform:translateY(-1px);
            background:var(--sand);
        }

        .filter-btn.active{
            background:var(--accent);
            color:#fff;
        }

        /* ===================== GRID PRODUK ===================== */
        .menu-grid{
            display:grid;
            grid-template-columns:repeat(3, 1fr);
            gap:28px;
        }

        .menu-card{
            background:var(--sand60);
            border-radius:12px;
            padding:15px;
            box-shadow:0 3px 8px rgba(0,0,0,0.12);
            display:flex;
            flex-direction:column;
        }

        .menu-card img{
            width:100%;
            height:200px;
            object-fit:cover;
            border-radius:10px;
            margin-bottom:10px;
        }

        .menu-card h3{
            margin:4px 0 6px 0;
            font-size:17px;
        }

        .menu-card p{
            margin:0 0 12px 0;
            font-size:15px;
        }

        .btn-details{
            margin-top:auto;
            padding:9px 10px;
            width:100%;
            border:0;
            border-radius:8px;
            background:var(--accent60);
            font-weight:700;
            font-size:15px;
            cursor:pointer;
            transition:0.15s ease;
        }

        .btn-details:hover{
            background:var(--accent);
            color:#fff;
        }

        /* ===================== RESPONSIVE GRID ===================== */
        @media (max-width: 992px){
            .menu-grid{
                grid-template-columns:repeat(2, 1fr);
            }
        }

        @media (max-width: 640px){
            .page-wrapper{
                padding:90px 16px 34px 16px;
            }
            .menu-grid{
                grid-template-columns:1fr;
            }
        }

        @media (max-width: 412px){
            .page-wrapper{
                padding:80px 12px 30px 12px;
            }

            .filter-container{
                margin-bottom:20px;
            }

            .filter-btn{
                padding:6px 16px;
                font-size:15px;
                margin:0 4px 6px 4px;
            }

            .menu-grid{
                grid-template-columns:1fr;
                gap:20px;
            }

            .menu-card{
                padding:12px;
            }

            .menu-card img{
                height:180px;
            }

            .menu-card h3{
                font-size:16px;
            }

            .menu-card p{
                font-size:14px;
            }

            .btn-details{
                padding:8px 8px;
                font-size:14px;
            }
        }
    </style>
</head>
<body>

<?= $this->include('layout/navbar') ?>

<?php $selectedCategory = $selectedCategory ?? 'all'; ?>

<div class="page-wrapper">

    <div class="filter-container">
        <!-- pakai query param agar aktif sesuai controller -->
        <a href="<?= base_url('menu?category=all') ?>">
            <button class="filter-btn <?= $selectedCategory == 'all' ? 'active' : '' ?>">All</button>
        </a>

        <?php foreach ($categories as $c) : ?>
            <a href="<?= base_url('menu?category=' . $c['id']) ?>">
                <button class="filter-btn <?= ((string)$selectedCategory) === ((string)$c['id']) ? 'active' : '' ?>">
                    <?= esc($c['name']) ?>
                </button>
            </a>
        <?php endforeach ?>
    </div>

    <div class="menu-grid">
        <?php if (!empty($products)) : ?>
            <?php foreach ($products as $p) : ?>
                <?php
                    $filename  = $p['gambar'] ?? '';
                    $uploadDir = FCPATH . 'uploads/products/';
                    $baseUrl   = base_url('uploads/products');
                    $imgUrl    = base_url('uploads/default.png');

                    if (!empty($filename)) {
                        if (filter_var($filename, FILTER_VALIDATE_URL)) {
                            $imgUrl = $filename;
                        } else {
                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                            if ($ext === '') {
                                $candidates = ['jpg','jpeg','png','webp'];
                                foreach ($candidates as $e) {
                                    $candidate = $filename . '.' . $e;
                                    if (is_file($uploadDir . $candidate)) {
                                        $filename = $candidate;
                                        break;
                                    }
                                }
                            }
                            if (is_file($uploadDir . $filename)) {
                                $imgUrl = $baseUrl . '/' . $filename;
                            }
                        }
                    }
                ?>

                <div class="menu-card">
                    <img src="<?= $imgUrl ?>" alt="<?= esc($p['name']) ?>">
                    <h3><?= esc($p['name']) ?></h3>
                    <p>Rp <?= number_format($p['price'], 0, ',', '.') ?></p>

                    <a href="<?= base_url('product/' . $p['id']) ?>">
                        <button class="btn-details">View Details</button>
                    </a>
                </div>

            <?php endforeach ?>
        <?php else : ?>
            <p style="grid-column:1/-1; text-align:center;">Produk belum tersedia.</p>
        <?php endif ?>
    </div>

</div>

<?= $this->include('layout/footer') ?>

</body>
</html>
