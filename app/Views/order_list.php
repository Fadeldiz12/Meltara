<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Pesanan</title>

<link href="https://fonts.googleapis.com/css2?family=Judson:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('css/layout.css') ?>">

<style>
body{
    background:#FFFBE9;
    font-family:"Judson", serif;
    margin:0;
}

/* container */
.order-list-wrapper{
    width:85%;
    max-width:950px;
    margin:120px auto 50px;
    background:#FBF6EA;
    padding:30px 35px;
    border-radius:12px;
    border:2px solid #D9C3A7;
}

/* judul */
.title{
    text-align:center;
    font-size:28px;
    font-weight:bold;
    color:#4c2b08;
    margin-bottom:25px;
}

/* tabel */
.table-order{
    width:100%;
    border-collapse:collapse;
    font-size:17px;
}

.table-order th{
    background:#D9C3A7;
    padding:12px;
    font-weight:bold;
    color:#4c2b08;
}

.table-order td{
    padding:10px 12px;
    background:#FFFDF7;
}

/* zebra effect */
.table-order tr:nth-child(even) td{
    background:#f7efe1;
}

/* hover */
.table-order tr:hover td{
    background:#e9dcc3;
    transition:.2s;
}

/* responsive */
@media(max-width:650px){
    .order-list-wrapper{
        padding:20px;
        margin-top:95px;
    }
    .table-order{
        font-size:15px;
    }
}

.view-btn{
    background:#6D4C41;
    color:white;
    padding:6px 12px;
    border-radius:5px;
    text-decoration:none;
    transition:.3s;
}
.view-btn:hover{
    background:#4E342E;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<?= $this->include('layout/navbar') ?>

<div class="order-list-wrapper">

    <h2 class="title">Daftar Pesanan Kamu</h2>

    <table class="table-order">
        <tr>
            <th>No Order</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php foreach($orders as $o): ?>
        <tr>
            <td><b><?= $o['order_number'] ?></b></td>
            <td><?= date('M d, Y',strtotime($o['order_date'])) ?></td>
            <td>Rp <?= number_format($o['total_amount'],0,',','.') ?></td>
            <td><?= $o['status'] ?></td>
            <td>
                <a class="view-btn" href="/orders/<?= $o['id'] ?>">Detail</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>

<?= $this->include('layout/footer') ?>
</body>
</html>