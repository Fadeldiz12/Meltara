<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order History</title>

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
.history-container{
    width:90%;
    max-width:1000px;
    margin:130px auto 60px;
    padding:0 15px;
}

/* TITLE */
.page-title{
    font-size:32px;
    font-weight:bold;
    text-align:center;
    margin-bottom:35px;
}

/* TABLE */
.table-wrapper{
    background:#FBF6EA;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
}

table{
    width:100%;
    border-collapse:collapse;
}

/* HEADER */
thead{
    background:#D6B49C;
}

thead th{
    padding:16px;
    font-size:18px;
    text-align:left;
    color:#3b2b24;
    font-weight:700;
}

/* BODY */
tbody tr{
    border-bottom:1px solid #E4D2BE;
    transition:background 0.2s ease;
}

tbody tr:hover{
    background:#F5EDD8;
}

tbody tr:last-child{
    border-bottom:none;
}

tbody td{
    padding:16px;
    font-size:17px;
    vertical-align:middle;
}

/* STATUS BADGE */
.status{
    padding:6px 12px;
    border-radius:8px;
    font-weight:bold;
    font-size:14px;
    display:inline-block;
    white-space:nowrap;
}

.status-pending{background:#FFF4C4;color:#9A7B00;}
.status-confirmed{background:#D7FFD9;color:#157A1F;}
.status-shipped{background:#D9E9FF;color:#1D48A7;}
.status-selesai{background:#EEDAFF;color:#6D2AA8;}
.status-cancelled{background:#FFD6D6;color:#B22424;}

/* ACTION BUTTONS CONTAINER */
.action-buttons{
    display:flex;
    flex-direction:column;
    gap:8px;
    align-items:flex-start;
}

/* BUTTON */
.btn-detail{
    padding:8px 14px;
    background:#6D4C41;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    font-weight:bold;
    font-size:14px;
    transition:all 0.25s ease;
    display:inline-block;
    cursor:pointer;
    white-space:nowrap;
}

.btn-detail:hover{
    background:#4E342E;
    transform:translateY(-2px);
    box-shadow:0 4px 12px rgba(109,76,65,0.3);
}

.btn-detail:active{
    transform:translateY(0);
}

.btn-review{
    padding:7px 12px;
    background:#8B7355;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
    font-weight:600;
    font-size:13px;
    transition:all 0.25s ease;
    display:inline-block;
    cursor:pointer;
    white-space:nowrap;
}

.btn-review:hover{
    background:#6D5A47;
    transform:translateY(-2px);
    box-shadow:0 4px 12px rgba(139,115,85,0.3);
}

.btn-review:active{
    transform:translateY(0);
}

/* REVIEW SECTION */
.review-section{
    margin-top:8px;
    padding-top:8px;
    border-top:1px dashed #D6B49C;
}

.review-label{
    font-size:12px;
    color:#8B7355;
    font-weight:600;
    margin-bottom:6px;
    display:block;
}

.review-items{
    display:flex;
    flex-direction:column;
    gap:6px;
}

/* EMPTY */
.empty{
    text-align:center;
    padding:40px 30px;
    font-size:18px;
    color:#8B7355;
}

/* RESPONSIVE */
@media (max-width: 768px){
    .history-container{
        margin:100px auto 40px;
    }
    
    .page-title{
        font-size:26px;
        margin-bottom:25px;
    }
    
    .table-wrapper{
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }
    
    table{
        min-width:700px;
    }
    
    thead th{
        padding:12px 10px;
        font-size:16px;
    }
    
    tbody td{
        padding:12px 10px;
        font-size:15px;
    }
    
    .btn-detail{
        padding:6px 10px;
        font-size:13px;
    }
    
    .btn-review{
        padding:5px 9px;
        font-size:12px;
    }
    
    .action-buttons{
        gap:6px;
    }
    
    .status{
        padding:5px 10px;
        font-size:13px;
    }
    
    .review-label{
        font-size:11px;
    }
}

@media (max-width: 480px){
    .page-title{
        font-size:22px;
    }
    
    .history-container{
        width:95%;
        padding:0 10px;
    }
    
    table{
        min-width:650px;
    }
    
    thead th{
        padding:10px 8px;
        font-size:14px;
    }
    
    tbody td{
        padding:10px 8px;
        font-size:14px;
    }
    
    .action-buttons{
        gap:5px;
    }
    
    .btn-detail{
        padding:5px 8px;
        font-size:12px;
    }
    
    .btn-review{
        padding:4px 7px;
        font-size:11px;
    }
    
    .review-section{
        margin-top:6px;
        padding-top:6px;
    }
    
    .review-items{
        gap:5px;
    }
}
</style>
</head>

<body>

<?= $this->include('layout/navbar') ?>

<div class="history-container">

    <h2 class="page-title">Order History</h2>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="5" class="empty">Belum ada pesanan.</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($orders as $order): ?>
                <?php 
                    $statusClass = [
                        'Pending'   => 'status-pending',
                        'Confirmed' => 'status-confirmed',
                        'Shipped'   => 'status-shipped',
                        'Selesai'   => 'status-selesai',
                        'Cancelled' => 'status-cancelled'
                    ][$order['status']] ?? 'status-pending';
                ?>
                <tr>
                    <td><b><?= esc($order['order_number']) ?></b></td>
                    <td><?= date('d M Y', strtotime($order['order_date'])) ?></td>
                    <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                    <td>
                        <span class="status <?= $statusClass ?>">
                            <?= esc($order['status']) ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= base_url('order_detail/' . $order['id']) ?>" class="btn-detail">
                                View Detail
                            </a>

                            <!-- TOMBOL REVIEW -->
                            <?php if ($order['status'] === 'Selesai' && !empty($order['items'])): ?>
                                <div class="review-section">
                                    <span class="review-label">Review Products:</span>
                                    <div class="review-items">
                                        <?php foreach ($order['items'] as $item): ?>
                                            <a href="<?= base_url('review/' . $item['product_id']) ?>" class="btn-review">
                                                ⭐ review
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->include('layout/footer') ?>

</body>
</html>