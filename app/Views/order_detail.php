<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Detail</title>

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

body{
    margin:0;
    font-family:"Judson", serif;
    background:white;
    color:#1c120d;
}
*{box-sizing:border-box}

.order-wrapper{
    width:85%;
    max-width:900px;
    background:#FBF6EA;
    margin:130px auto 60px;
    padding:40px 55px;
    border-radius:14px;
    border:2px solid #D9C3A7;
    box-shadow:0 6px 20px rgba(0,0,0,0.06);
}

.order-title{
    text-align:center;
    font-size:32px;
    font-weight:bold;
    margin-bottom:35px;
}

.summary-box{
    background:#FFFDF8;
    padding:18px;
    border-radius:10px;
    border:2px solid #C9B299;
    margin-top:32px;
}
.summary-box h4{
    margin-bottom:12px;
    font-size:19px;
    font-weight:bold;
}
.summary-box table{width:100%;font-size:16px}
.summary-box td{padding:5px 0}
.summary-box tr:last-child td{
    font-size:18px;
    font-weight:bold;
    border-top:1px solid #D1C0A3;
    padding-top:8px;
}

/* Tombol sejajar */
.button-row{
    display:flex;
    justify-content:space-between;
    margin-top:25px;
    gap:10px;
}

.btn-back,
.btn-review{
    display:inline-block;
    flex:1;
    text-align:center;
    background:#6D4C41;
    padding:12px 18px;
    border-radius:6px;
    color:white;
    text-decoration:none;
    font-weight:bold;
    transition:.3s;
}

.btn-back:hover{background:#4E342E;}
.btn-review:hover{background:#6D3914;}

/* Popup Overlay */
.popup-overlay{
    position:fixed;
    top:0; left:0; width:100%; height:100%;
    background:rgba(0,0,0,0.5);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:9999;
}
.popup-box{
    background:white;
    padding:25px 30px;
    border-radius:12px;
    width:90%; max-width:400px;
    box-shadow:0 4px 15px rgba(0,0,0,0.2);
    font-family:"Judson", serif;
}
.popup-box h3{
    margin-top:0;
    text-align:center;
    margin-bottom:18px;
}
.popup-box input,
.popup-box textarea{
    width:100%;
    padding:10px;
    border:1px solid #D1C0A3;
    border-radius:6px;
    margin-bottom:14px;
    font-size:16px;
}

.btn-submit-review{
    width:100%;
    background:#5B3A29;
    padding:10px;
    border:none;
    color:white;
    border-radius:6px;
    font-size:17px;
    cursor:pointer;
    margin-bottom:10px;
}
.btn-close-review{
    width:100%;
    background:#B7957F;
    padding:10px;
    border:none;
    color:white;
    border-radius:6px;
    font-size:17px;
    cursor:pointer;
}

/* Flash message */
.flash-success{
    width:100%;
    background:#6D3914;
    color:white;
    padding:12px 18px;
    border-radius:8px;
    margin-bottom:20px;
    text-align:center;
    font-size:17px;
    animation:fadeOut 5s forwards;
}

@keyframes fadeOut{
    0%{opacity:1;}
    70%{opacity:1;}
    100%{opacity:0;}
}

@media(max-width:600px){
    .order-wrapper{padding:25px 22px;margin-top:100px}
    table{font-size:15px;}
    .button-row{flex-direction:column;}
}
</style>
</head>

<body>

<?= $this->include('layout/navbar') ?>

<div class="order-wrapper">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <h2 class="order-title">Your Order has been confirmed!</h2>

    <!-- ORDER INFO -->
    <div class="summary-box">
        <h4>Order Details</h4>
        <table>
            <tr>
                <td>Order Number:</td>
                <td><b><?= esc($order['order_number'] ?? '-') ?></b></td>
            </tr>
            <tr>
                <td>Order Date:</td>
                <td><?= isset($order['order_date']) ? date('M d, Y', strtotime($order['order_date'])) : '-' ?></td>
            </tr>
            <tr>
                <td>Status:</td>
                <td><b><?= esc($order['status'] ?? '-') ?></b></td>
            </tr>
            <tr>
                <td>Customer:</td>
                <td><?= esc($shipping['recipient'] ?? '-') ?></td>
            </tr>
            <tr>
                <td>Shipping Address:</td>
                <td><?= esc($shipping['address'] ?? '-') ?></td>
            </tr>
            <tr>
                <td>Delivery Status:</td>
                <td><b style="color:#6D3914;"><?= esc($shipping['delivery_status'] ?? 'Dikemas') ?></b></td>
            </tr>
            <tr>
                <<?php
$statusPay = $order['payment_status'] ?? 'Pending';
?>

<?php if ($statusPay === 'Pending'): ?>
    <b style="color:orange;">Menunggu Konfirmasi</b>
<?php elseif ($statusPay === 'Success'): ?>
    <b style="color:green;">Pembayaran Berhasil</b>
<?php elseif ($statusPay === 'Failed'): ?>
    <b style="color:red;">Pembayaran Gagal</b>
<?php else: ?>
    <b style="color:gray;">Status Tidak Diketahui</b>
<?php endif; ?>


            </tr>
        </table>
    </div>

    <!-- ITEMS -->
    <div class="summary-box">
        <h4>Items Ordered</h4>
        <table>
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td>
                        <?= esc($item['product_name']) ?> (x<?= (int)$item['quantity'] ?>)
                    </td>
                    <td style="text-align:right">
                        Rp <?= number_format($item['subtotal'],0,',','.') ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" style="text-align:center">No items found</td>
                </tr>
            <?php endif; ?>
            <tr>
                <td><b>Total</b></td>
                <td style="text-align:right">
                    <b>Rp <?= number_format($total ?? 0,0,',','.') ?></b>
                </td>
            </tr>
        </table>
    </div>

    <div class="button-row">
       <a href="<?= base_url('/histori') ?>" class="btn-back">
    ← Kembali ke Histori
</a>

        <?php if (($order['status'] ?? '') === 'Completed'): ?>
            <a class="btn-review" onclick="openReviewPopup()">+ Add Review</a>
        <?php endif; ?>
    </div>

</div>

<!-- REVIEW POPUP -->
<div id="reviewPopup" class="popup-overlay">
    <div class="popup-box">
        <h3>Write a Review</h3>

        <form method="POST" action="<?= base_url('review/save') ?>">

            <input type="hidden" name="product_id" value="<?= esc($items[0]['product_id'] ?? '') ?>">
            <input type="hidden" name="user_id" value="<?= session()->get('user_id') ?>">

            <label>Rating (1 - 5)</label>
            <input type="number" name="rating" min="1" max="5" required>

            <label>Your Comment</label>
            <textarea name="comment" rows="4" required></textarea>

            <button type="submit" class="btn-submit-review">Submit Review</button>
            <button type="button" class="btn-close-review" onclick="closeReviewPopup()">Cancel</button>
        </form>
    </div>
</div>

<script>
function openReviewPopup(){
    document.getElementById("reviewPopup").style.display = "flex";
}
function closeReviewPopup(){
    document.getElementById("reviewPopup").style.display = "none";
}
</script>

<?= $this->include('layout/footer') ?>

</body>
</html>
