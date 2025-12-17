<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <link href="https://fonts.googleapis.com/css2?family=Judson:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/layout.css') ?>">

    <style>
        :root {
            --accent: #CEAB93;
            --bg-page: #FFFBE9;
            --card: #FFFDF7;
        }

        body {
            margin: 0;
            font-family: "Judson", serif;
            background: white;
            color: #1c120d;
        }

        * { box-sizing: border-box; }

        .checkout-container {
            width: 85%;
            max-width: 900px;
            background: #FBF6EA;
            margin: 130px auto 60px;
            padding: 40px 55px;
            border-radius: 14px;
            border: 2px solid #D9C3A7;
            box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        }

        .checkout-title {
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 35px;
        }

        label {
            font-size: 17px;
            font-weight: bold;
            margin-top: 18px;
            display: block;
        }

        .input-box {
            width: 100%;
            padding: 14px;
            border: 2px solid #D6C3A5;
            background: var(--card);
            border-radius: 7px;
            margin-top: 6px;
            font-size: 16px;
        }

        /* ================= PAYMENT ================= */
        .payment-section { margin-top: 25px; }

        .payment-option {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        /* ================= QRIS CARD ================= */
        .qris-card {
            display: none;
            margin-top: 20px;
            padding: 22px;
            border-radius: 14px;
            background: var(--card);
            border: 2px dashed #D9C3A7;
            animation: fadeIn .25s ease;
        }

        .qris-title{
            font-size:18px;
            font-weight:700;
            margin-bottom:14px;
            color:#6b4b34;
            text-align:center;
        }

        .qris-image-wrapper{
            display:flex;
            flex-direction:column;
            align-items:center;
            gap:10px;
        }

        .qris-image-wrapper img{
            width:220px;
            border-radius:10px;
            box-shadow:0 4px 12px rgba(0,0,0,0.12);
        }

        .qris-hint{
            font-size:14px;
            color:#7a5a40;
            margin:0;
            text-align:center;
        }

        .qris-divider{
            height:1px;
            background:#e2d3c1;
            margin:18px 0;
        }

        .qris-upload{
            text-align:left;
        }

        .qris-upload label{
            font-size:15px;
            font-weight:700;
            margin-bottom:6px;
            display:block;
        }

        .qris-upload input[type="file"]{
            width:100%;
            padding:10px;
            border-radius:6px;
            border:1px solid #d6c3a5;
            background:#fff;
            font-size:14px;
        }

        .qris-upload small{
            display:block;
            margin-top:6px;
            color:#8b6f54;
            font-size:13px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ================= SUMMARY ================= */
        .summary-box {
            background: #FFFDF8;
            padding: 18px;
            border-radius: 10px;
            border: 2px solid #C9B299;
            margin-top: 32px;
        }

        .summary-box table {
            width: 100%;
            font-size: 16px;
        }

        .summary-box tr:last-child td {
            font-size: 18px;
            font-weight: bold;
            border-top: 1px solid #D1C0A3;
            padding-top: 8px;
        }

        .btn-order {
            width: 270px;
            display: block;
            margin: 40px auto 0;
            padding: 14px;
            background: #C39B75;
            color: white;
            border: none;
            font-size: 17px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
        }

        @media (max-width: 600px) {
            .checkout-container {
                padding: 25px 22px;
            }
            .btn-order {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<?= $this->include('layout/navbar') ?>

<div class="checkout-container">
    <h2 class="checkout-title">Checkout</h2>

    <form action="<?= base_url('/checkout/process') ?>" method="POST"
          enctype="multipart/form-data" onsubmit="return validateCheckout()">

        <label>Full Name</label>
        <input type="text" name="recipient" required class="input-box">

        <label>Address</label>
        <input type="text" name="address" required class="input-box">

        <label>Phone Number</label>
        <input type="text" name="phone" required class="input-box">

        <!-- PAYMENT -->
        <div class="payment-section">
            <h4>Payment Method</h4>

            <div class="payment-option">
                <input type="radio" id="cod" name="payment_method" value="COD" required>
                <label for="cod">Cash On Delivery</label>
            </div>

            <div class="payment-option">
                <input type="radio" id="qris" name="payment_method" value="QRIS" required>
                <label for="qris">QRIS</label>
            </div>

            <!-- QRIS CARD (RAPI) -->
            <div id="qrisPopup" class="qris-card">

                <h5 class="qris-title">Pembayaran QRIS</h5>

                <div class="qris-image-wrapper">
                    <img src="<?= base_url('images/qris.jpg') ?>" alt="QRIS Code">
                    <p class="qris-hint">
                        Scan QR menggunakan aplikasi e-wallet / m-banking
                    </p>
                </div>

                <div class="qris-divider"></div>

                <div class="qris-upload">
                    <label for="payment_proof_input">Upload Bukti Pembayaran</label>
                    <input type="file"
                           id="payment_proof_input"
                           name="payment_proof"
                           accept="image/*">
                    <small>Format JPG / PNG • Maksimal 2MB</small>
                </div>

            </div>
        </div>

        <!-- ORDER SUMMARY -->
        <div class="summary-box">
            <h4>Order Summary</h4>
            <table>
                <?php foreach ($cart as $item): ?>
                <tr>
                    <td><?= esc($item['name']) ?> (x<?= $item['qty'] ?>)</td>
                    <td style="text-align:right">
                        Rp <?= number_format($item['price'] * $item['qty'], 0, ',', '.') ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td>Total</td>
                    <td style="text-align:right">
                        <b>Rp <?= number_format($total, 0, ',', '.') ?></b>
                    </td>
                </tr>
            </table>
        </div>

        <input type="hidden" name="subtotal" value="<?= esc($subtotal) ?>">
        <input type="hidden" name="total" value="<?= esc($total) ?>">

        <button type="submit" class="btn-order">Confirm Order</button>
    </form>
</div>

<?= $this->include('layout/footer') ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const qris = document.getElementById("qris");
    const cod  = document.getElementById("cod");
    const popup = document.getElementById("qrisPopup");

    qris.addEventListener("change", () => popup.style.display = "block");
    cod.addEventListener("change", () => popup.style.display = "none");
});

function validateCheckout() {
    const qris  = document.getElementById("qris");
    const proof = document.getElementById("payment_proof_input");

    if (qris.checked && (!proof || proof.files.length === 0)) {
        alert("Silakan upload bukti pembayaran QRIS terlebih dahulu.");
        return false;
    }
    return true;
}
</script>

</body>
</html>
