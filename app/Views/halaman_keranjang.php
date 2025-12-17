<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Keranjang Belanja</title> 
    
    <link href="https://fonts.googleapis.com/css2?family=Judson:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/layout.css') ?>">

    <style>
        :root{
            --accent:#CEAB93;
            --accent60:rgba(206,171,147,0.60);
            --bg-page:#FFFBE9;
            --sand:#E3CAA5;
            --sand60:rgba(227,202,165,0.60);
        }

        *{ box-sizing:border-box; }

        /* === AGAR FOOTER DI BAWAH === */
        html, body{
            margin:0;
            padding:0;
            height:100%;
            display:flex;
            flex-direction:column;
            overflow-x:hidden;
            font-family:"Judson", serif;
            background:white;
            color:#1c120d;
        }

        .page-wrapper{
            flex:1;
            max-width:900px;
            margin:120px auto 50px auto;
            padding:0 32px;
            width:100%;
        }

        /* === CART ITEM STYLE === */
        .cart-item-box{
            display:flex;
            align-items:center;
            justify-content:flex-start;
            padding:15px 0;
            border-bottom:1px solid #ddd;
            gap:40px;
        }

        .cart-item-box img{
            width:90px;
            height:90px;
            object-fit:cover;
            border-radius:8px;
            flex-shrink:0;
        }

        .item-name{
            flex-grow:1;
            font-weight:600;
            font-size:18px;
        }

        .qty-box{
            display:flex;
            align-items:center;
            gap:5px;
        }

        .qty-box button{
            width:30px;
            height:30px;
            border:1px solid var(--accent);
            background:var(--bg-page);
            cursor:pointer;
            font-weight:bold;
            border-radius:4px;
            transition:0.2s;
        }

        .qty-box button:hover{
            background:var(--accent);
            color:#fff;
        }

        .item-price{
            font-weight:700;
            font-size:18px;
            margin-left:auto;
        }

        .btn-delete{
            background:none;
            border:none;
            cursor:pointer;
            font-size:20px;
            margin-left:20px;
        }

        .cart-summary{
            margin-top:50px;
            max-width:400px;
            margin-left:auto;
            margin-right:auto;
            padding:20px;
            background:var(--bg-page);
            border-radius:12px;
            text-align:center;
            box-shadow:0 3px 10px rgba(0,0,0,0.1);
        }

        .btn-checkout{
            display:block;
            padding:10px 20px;
            background:#6D4C41;
            color:white;
            text-decoration:none;
            border-radius:8px;
            font-weight:bold;
            width:100%;
        }

        @media(max-width:600px){
            .page-wrapper{
                margin-top:95px;
                padding:0 20px;
            }

            .cart-item-box{
                display:grid;
                grid-template-columns:80px 1fr 40px;
                grid-template-areas:
                    "img name delete"
                    "img price price"
                    "qty qty qty";
                gap:8px 10px;
            }

            .cart-item-box img{ grid-area:img; width:80px; height:80px; }
            .item-name{ grid-area:name; font-size:16px; }
            .item-price{ grid-area:price; text-align:right; font-size:16px; padding-right:40px; }
            .qty-box{ grid-area:qty; margin-top:10px; }
            .btn-delete{ grid-area:delete; justify-self:end; }
        }
    </style>
</head>

<body>

<?= $this->include('layout/navbar') ?>

<div class="page-wrapper">

    <?php if(empty($cart)): ?>
        <h2 style="text-align:center;margin:50px 0;">Keranjang Kosong</h2>

    <?php else: ?>
        <?php $total = 0; foreach($cart as $item): ?>

        <div class="cart-item-box">

            <?php
                $filename = $item['gambar'];
                $uploadDir = FCPATH . 'uploads/products/';
                $baseUrl   = base_url('uploads/products');
                $img       = base_url('uploads/default.png');

                if (filter_var($filename, FILTER_VALIDATE_URL)) {
                    $img = $filename;
                } elseif (is_file($uploadDir . $filename)) {
                    $img = $baseUrl . '/' . $filename;
                }
            ?>

            <img src="<?= $img ?>">
            <div class="item-name"><?= $item['name'] ?></div>

            <form action="/cart/update" method="post" class="qty-box">
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                <button name="action" value="minus">-</button>
                <span><?= $item['qty'] ?></span>
                <button name="action" value="plus">+</button>
            </form>

            <div class="item-price">Rp <?= number_format($item['price']) ?></div>

            <form action="/cart/remove" method="post">
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                <button class="btn-delete">🗑</button>
            </form>

        </div>

        <?php $total += $item['price'] * $item['qty']; endforeach; ?>

        <div class="cart-summary">
            <h3>Order Summary</h3>
            <p>Total: <b>Rp <?= number_format($total) ?></b></p>

            <?php if(session()->get('logged_in')): ?>
                <a href="/checkout" class="btn-checkout">Proceed to Checkout</a>
            <?php else: ?>
                <a href="/login" class="btn-checkout">Login for Checkout</a>
            <?php endif; ?>
        </div>

    <?php endif; ?>

</div>

<?= $this->include('layout/footer') ?>

</body>
</html>
