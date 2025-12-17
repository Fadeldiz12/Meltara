<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tulis Ulasan</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Judson:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/layout.css') ?>">
    
    <style>
        body{
            margin:0;
            background:#FFFBE9;
            font-family:"Judson", serif;
            color:#3b2b24;
        }

        /* CONTAINER */
        .review-container{
            width:90%;
            max-width:760px;
            margin:130px auto 60px;
            padding:0 15px;
        }

        .review-box{
            background:#FBF6EA;
            padding:40px;
            border-radius:16px;
            box-shadow:0 8px 25px rgba(0,0,0,0.08);
        }

        /* TITLE */
        .page-title{
            font-size:32px;
            font-weight:bold;
            margin:0 0 10px 0;
            color:#3b2b24;
        }

        .page-subtitle{
            font-size:16px;
            color:#8B7355;
            margin:0 0 30px 0;
        }

        /* PRODUCT INFO */
        .product-info{
            background:#fff;
            padding:20px;
            border-radius:12px;
            margin-bottom:30px;
            border:2px solid #E4D2BE;
        }

        .product-label{
            font-size:14px;
            font-weight:600;
            color:#8B7355;
            margin-bottom:8px;
            display:block;
        }

        .product-name{
            font-size:20px;
            font-weight:700;
            color:#3b2b24;
        }

        /* ALERT MESSAGES */
        .alert{
            padding:14px 18px;
            border-radius:10px;
            margin-bottom:25px;
            font-weight:600;
            font-size:15px;
        }

        .alert-error{
            background:#FFD6D6;
            color:#B22424;
            border:1px solid #FF9999;
        }

        .alert-success{
            background:#D7FFD9;
            color:#157A1F;
            border:1px solid #7FD684;
        }

        /* FORM */
        .form-row{
            margin-bottom:24px;
        }

        label{
            display:block;
            margin-bottom:10px;
            font-weight:700;
            font-size:16px;
            color:#3b2b24;
        }

        /* RATING STARS */
        .rating-container{
            display:flex;
            align-items:center;
            gap:8px;
            margin-bottom:12px;
        }

        .star-rating{
            display:flex;
            gap:4px;
            flex-direction:row-reverse;
            justify-content:flex-end;
        }

        .star-rating input{
            display:none;
        }

        .star-rating label{
            cursor:pointer;
            font-size:40px;
            color:#D6B49C;
            transition:all 0.2s ease;
            margin:0;
        }

        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label{
            color:#FDB022;
            transform:scale(1.1);
        }

        .rating-text{
            font-size:18px;
            font-weight:700;
            color:#6D4C41;
            min-width:150px;
        }

        /* SELECT DROPDOWN */
        select{
            width:100%;
            padding:14px;
            border:2px solid #D6B49C;
            border-radius:10px;
            font-size:16px;
            font-family:"Judson", serif;
            background:#fff;
            color:#3b2b24;
            cursor:pointer;
            transition:all 0.25s ease;
        }

        select:focus{
            outline:none;
            border-color:#6D4C41;
            box-shadow:0 0 0 3px rgba(109,76,65,0.1);
        }

        /* TEXTAREA */
        textarea{
            width:100%;
            padding:14px;
            border:2px solid #D6B49C;
            border-radius:10px;
            font-size:16px;
            font-family:"Judson", serif;
            resize:vertical;
            min-height:140px;
            transition:all 0.25s ease;
            color:#3b2b24;
        }

        textarea:focus{
            outline:none;
            border-color:#6D4C41;
            box-shadow:0 0 0 3px rgba(109,76,65,0.1);
        }

        textarea::placeholder{
            color:#B8A08E;
        }

        .char-count{
            text-align:right;
            font-size:13px;
            color:#8B7355;
            margin-top:6px;
        }

        /* BUTTONS */
        .form-actions{
            display:flex;
            gap:12px;
            margin-top:30px;
        }

        .btn{
            padding:14px 24px;
            border-radius:10px;
            font-weight:700;
            font-size:16px;
            text-decoration:none;
            border:none;
            cursor:pointer;
            transition:all 0.25s ease;
            font-family:"Judson", serif;
        }

        .btn-primary{
            background:#6D4C41;
            color:#fff;
            flex:1;
        }

        .btn-primary:hover{
            background:#4E342E;
            transform:translateY(-2px);
            box-shadow:0 6px 20px rgba(109,76,65,0.3);
        }

        .btn-primary:active{
            transform:translateY(0);
        }

        .btn-secondary{
            background:#D6B49C;
            color:#3b2b24;
            padding:14px 20px;
        }

        .btn-secondary:hover{
            background:#C4A48C;
            transform:translateY(-2px);
        }

        /* RESPONSIVE */
        @media (max-width: 768px){
            .review-container{
                margin:100px auto 40px;
            }

            .review-box{
                padding:30px 24px;
            }

            .page-title{
                font-size:26px;
            }

            .page-subtitle{
                font-size:14px;
            }

            .product-info{
                padding:16px;
            }

            .product-name{
                font-size:18px;
            }

            .star-rating label{
                font-size:36px;
            }

            .rating-text{
                font-size:16px;
                min-width:130px;
            }

            .form-actions{
                flex-direction:column;
            }

            .btn{
                width:100%;
            }
        }

        @media (max-width: 480px){
            .review-container{
                width:95%;
                padding:0 10px;
            }

            .review-box{
                padding:24px 18px;
            }

            .page-title{
                font-size:22px;
            }

            .star-rating label{
                font-size:32px;
            }

            .rating-text{
                font-size:15px;
                min-width:110px;
            }

            select, textarea{
                padding:12px;
                font-size:15px;
            }

            .btn{
                padding:12px 20px;
                font-size:15px;
            }
        }
    </style>
</head>
<body>

<?= $this->include('layout/navbar') ?>

<div class="review-container">
    <div class="review-box">
        <h1 class="page-title">Tulis Ulasan Produk</h1>
        <p class="page-subtitle">Bagikan pengalaman Anda dengan produk ini</p>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                ⚠️ <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                ✓ <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if(isset($product) && $product): ?>
            <div class="product-info">
                <span class="product-label">Produk yang akan direview:</span>
                <div class="product-name"><?= esc($product['name']) ?></div>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/review/save') ?>" method="post" id="reviewForm">
            <?= csrf_field() ?>
            <input type="hidden" name="product_id" value="<?= esc($productId) ?>">
            <input type="hidden" name="rating" id="ratingValue" value="">

            <div class="form-row">
                <label>Rating Produk</label>
                <div class="rating-container">
                    <div class="star-rating">
                        <input type="radio" name="star-rating" id="star5" value="5">
                        <label for="star5">★</label>
                        <input type="radio" name="star-rating" id="star4" value="4">
                        <label for="star4">★</label>
                        <input type="radio" name="star-rating" id="star3" value="3">
                        <label for="star3">★</label>
                        <input type="radio" name="star-rating" id="star2" value="2">
                        <label for="star2">★</label>
                        <input type="radio" name="star-rating" id="star1" value="1">
                        <label for="star1">★</label>
                    </div>
                    <span class="rating-text" id="ratingText">Pilih rating</span>
                </div>
            </div>

            <div class="form-row">
                <label>Ulasan Anda (opsional)</label>
                <textarea 
                    name="comment" 
                    id="comment" 
                    placeholder="Ceritakan pengalaman Anda dengan produk ini. Apa yang Anda sukai? Apakah sesuai ekspektasi?" 
                    maxlength="2000"
                ><?= old('comment') ?></textarea>
                <div class="char-count">
                    <span id="charCount">0</span> / 2000 karakter
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                <a href="<?= base_url('order_history') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->include('layout/footer') ?>

<script>
    // Star rating functionality
    const starInputs = document.querySelectorAll('input[name="star-rating"]');
    const ratingValue = document.getElementById('ratingValue');
    const ratingText = document.getElementById('ratingText');
    
    const ratingTexts = {
        5: 'Sangat Baik ⭐⭐⭐⭐⭐',
        4: 'Bagus ⭐⭐⭐⭐',
        3: 'Cukup ⭐⭐⭐',
        2: 'Kurang ⭐⭐',
        1: 'Buruk ⭐'
    };

    starInputs.forEach(input => {
        input.addEventListener('change', function() {
            ratingValue.value = this.value;
            ratingText.textContent = ratingTexts[this.value];
        });
    });

    // Character counter
    const commentTextarea = document.getElementById('comment');
    const charCount = document.getElementById('charCount');

    if (commentTextarea) {
        charCount.textContent = commentTextarea.value.length;
        
        commentTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }

    // Form validation
    document.getElementById('reviewForm').addEventListener('submit', function(e) {
        if (!ratingValue.value) {
            e.preventDefault();
            alert('Mohon pilih rating terlebih dahulu!');
            return false;
        }
    });
</script>

</body>
</html>