<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Daftar Pesanan</title> 
    
    <link href="https://fonts.googleapis.com/css2?family=Judson:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/layout.css') ?>">

    <style>
        :root{
            --accent:#CEAB93;
            --accent60:rgba(206,171,147,0.60);
            --sand:#E3CAA5;
            --sand60:rgba(227,202,165,0.60);
            --cream:#FFFBE9;
            --white:#FFFFFF;
        }

        *{ box-sizing:border-box; }

        /* Layout agar footer turun ke bawah */
        html, body{
            margin:0;
            padding:0;
            height:100%;
            display:flex;
            flex-direction:column;
            overflow-x:hidden;
            font-family:"Judson", serif;
            background:var(--white);
        }

        .page-wrapper{
            max-width:900px;
            margin:0 auto 60px auto;
            padding:120px 24px 40px 24px;
            background:var(--cream);
            border-radius:16px;
            box-shadow:0 4px 14px rgba(0,0,0,0.06);
            flex:1;
        }

        .header{
            font-size:24px;
            font-weight:bold;
            margin-bottom:25px;
            text-align:center;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:10px;
        }

        .empty{
            text-align:center;
            margin-top:40px;
            font-size:18px;
            color:#8b7d6b;
        }

        .card{
            background:#fff;
            border:1px solid #d6c3ae;
            padding:20px;
            margin-bottom:15px;
            border-radius:8px;
            box-shadow:0 2px 8px rgba(0,0,0,0.06);
        }

        .card:hover{
            background:#f7efe6;
            transition:.2s;
        }

        .btn{
            background:#c5a17d;
            padding:8px 15px;
            border-radius:6px;
            color:white;
            text-decoration:none;
            font-weight:600;
        }

        .btn:hover{
            background:#a88460;
        }
    </style>
</head>

<body>

<?= $this->include('layout/navbar') ?>

<div class="page-wrapper">

    <div class="header">
        📦 Daftar Pesanan Anda
    </div>

    <?php if(empty($orders)): ?>
        <p class="empty">Belum ada pesanan yang dibuat.</p>
    <?php endif; ?>

    <?php foreach($orders as $o): ?>
        <div class="card">
            <b>No.Order :</b> <?= $o['order_number'] ?><br>
            <b>Tanggal :</b> <?= $o['order_date'] ?><br>
            <b>Total :</b> Rp<?= number_format($o['total_amount']) ?><br>
            <b>Status :</b> 
            <span style="color:green"><?= $o['status'] ?></span>
            <br><br>

            <a class="btn" href="/pesanan/<?= $o['id'] ?>">Lihat Detail</a>
        </div>
    <?php endforeach; ?>

</div>

<?= $this->include('layout/footer') ?>

</body>
</html>
