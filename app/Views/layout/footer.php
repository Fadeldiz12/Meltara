<div class="footer">
    <div class="footer-links">
        <a href="#">Contact Us</a>
        <span>|</span>
        <a href="#">About Us</a>
    </div>

    <div class="footer-icons">
        <svg class="ig-icon" viewBox="0 0 24 24" fill="none">
            <rect x="3" y="3" width="18" height="18" rx="5" stroke="#2b2017" stroke-width="1.7"/>
            <circle cx="12" cy="12" r="4.2" stroke="#2b2017" stroke-width="1.7"/>
            <circle cx="17" cy="7" r="1.3" fill="#2b2017"/>
        </svg>
    </div>
</div>

<style>
    .footer {
        width: 100%;
        padding: 22px 40px;
        background: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-family: "Judson", serif;
        margin-top: 50px;
        border-top: 2px solid rgba(0,0,0,0.07);
    }

    .footer-links {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        color: #2b2017;
    }

    .footer-links a {
        text-decoration: none;
        color: #2b2017;
        font-weight: 600;
    }

    .footer-links a:hover {
        color: #CEAB93;
    }

    .footer-icons {
        display: flex;
        align-items: center;
    }

    .ig-icon {
        width: 28px;
        height: 28px;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .ig-icon:hover rect,
    .ig-icon:hover circle {
        stroke: #CEAB93;
        fill: #CEAB93;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .footer {
            flex-direction: column;
            gap: 15px;
            padding: 20px 30px;
        }

        .footer-links {
            font-size: 14px;
        }
    }

    @media (max-width: 480px) {
        .footer {
            padding: 15px 20px;
            gap: 10px;
        }

        .footer-links {
            flex-direction: column;
            gap: 5px;
            font-size: 13px;
        }

        .footer-links span {
            display: none; /* Sembunyikan separator di mobile */
        }

        .ig-icon {
            width: 24px;
            height: 24px;
        }
    }
</style>