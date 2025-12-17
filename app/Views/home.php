<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= esc($title ?? 'Home') ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Judson:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/layout.css') ?>">

    <style>
        :root{
            --accent:#CEAB93;
            --accent60:rgba(206,171,147,.6);
            --bg-page:#FFFBE9;
            --sand:#E3CAA5;
            --sand60:rgba(227,202,165,.6);
        }

        *{box-sizing:border-box}
        body{
            margin:0;
            font-family:"Judson",serif;
            background:#fff;
            color:#1c120d;
        }

        .page-wrapper{
            max-width:1200px;
            margin:0 auto 80px;
            padding:100px 32px 0;
        }

        /* HERO */
        .hero{
            background:var(--accent);
            border-radius:16px;
            padding:60px;
            display:flex;
            gap:40px;
            align-items:center;
            justify-content:space-between;
        }

        .hero-text{max-width:440px}
        .hero-text h1{margin:0;font-size:42px}
        .hero-text p{margin-top:16px;font-size:18px}
        .hero img{width:420px;border-radius:12px}

        /* CATEGORIES */
        .categories{
            margin-top:40px;
            background:var(--sand);
            border-radius:16px;
            padding:40px;
            text-align:center;
        }

        .category-list{
            margin-top:32px;
            display:flex;
            justify-content:center;
            gap:32px;
        }

        .category-box{
            width:220px;height:120px;
            background:var(--bg-page);
            border-radius:14px;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            font-size:18px;
            font-weight:700;
            box-shadow:0 4px 12px rgba(0,0,0,.08);
        }

        /* FEATURED */
        .featured-section{margin-top:52px;text-align:center}
        .featured-wrapper{
            background:var(--bg-page);
            border-radius:16px;
            padding:32px;
        }

        .featured-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:40px;
            max-width:820px;
            margin:0 auto;
        }

        .featured-card{
            background:var(--sand60);
            border-radius:14px;
            padding:16px;
        }

        .featured-card img{
            width:100%;
            height:200px;
            object-fit:cover;
            border-radius:10px;
        }

        .btn-details{
            width:100%;
            padding:8px;
            border:none;
            border-radius:8px;
            background:var(--accent60);
            font-weight:700;
            cursor:pointer;
        }

        /* TESTIMONI */
        .testimoni{
            margin-top:56px;
            background:var(--accent);
            border-radius:16px;
            padding:46px;
            text-align:center;
        }

        .testi-grid{
            margin-top:32px;
            display:flex;
            gap:32px;
            justify-content:center;
            flex-wrap:wrap;
        }

        .testi-box{
            width:260px;
            background:var(--bg-page);
            border-radius:12px;
            padding:22px;
            box-shadow:0 3px 10px rgba(0,0,0,.12);
            font-size:16px;
        }

        .stars{color:#C19A6B;margin-top:6px}

        @media(max-width:900px){
            .hero{flex-direction:column;text-align:center}
            .featured-grid{grid-template-columns:1fr}
            .testi-grid{flex-direction:column;align-items:center}
        }
    </style>
</head>

<body>

<?= $this->include('layout/navbar') ?>

<div class="page-wrapper">

    <!-- HERO -->
    <section class="hero">
        <div class="hero-text">
            <h1>Sweet Moments, Melt in Every Bite</h1>
            <p>Indulge in Meltara's exquisite desserts, crafted for pure bliss.</p>
        </div>
        <img src="<?= base_url('images/hero-cake.png') ?>" alt="Meltara">
    </section>

    <!-- CATEGORIES -->
    <section class="categories">
        <h2>Our Categories</h2>
        <div class="category-list">
            <div class="category-box">🍪 Cookies</div>
            <div class="category-box">🍰 Cake</div>
            <div class="category-box">🥤 Drinks</div>
        </div>
    </section>

    <!-- FEATURED (STATIC) -->
    <section class="featured-section">
        <h2>Featured Categories</h2>
        <div class="featured-wrapper">
            <div class="featured-grid">
                <div class="featured-card">
                    <img src="<?= base_url('images/lemon-cake.png') ?>">
                    <h3>Lemon Cheese Mousse Cake</h3>
                    <p>Rp 28.000</p>
                    <button class="btn-details">View Details</button>
                </div>
                <div class="featured-card">
                    <img src="<?= base_url('images/blackberry.png') ?>">
                    <h3>Blackberry Breeze</h3>
                    <p>Rp 32.000</p>
                    <button class="btn-details">View Details</button>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONI DINAMIS -->
    <section class="testimoni">
        <h2>What Our Customers Say</h2>

        <div class="testi-grid">

            <?php if (empty($reviews)): ?>
                <p style="color:#555">Belum ada review dari pelanggan.</p>
            <?php else: ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="testi-box">
                        <p>“<?= esc($review['comment']) ?>”</p>

                        <div style="font-weight:bold;margin-top:10px">
                            – <?= esc($review['username']) ?>
                        </div>

                        <div class="stars">
                            <?php for ($i=1;$i<=5;$i++): ?>
                                <?= $i <= (int)$review['rating'] ? '★' : '☆' ?>
                            <?php endfor ?>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>

        </div>
    </section>

</div>

<?= $this->include('layout/footer') ?>

</body>
</html>
