        <footer class="site-footer">
            <div class="footer-inner">
                <div class="footer-columns">
                    <div class="footer-col">
                        <h4>Support</h4>
                        <a href="#">Customer Support</a>
                        <a href="#">Contact us</a>
                        <a href="#">FAQ</a>
                    </div>

                    <div class="footer-col">
                        <h4>About</h4>
                        <a href="#">About us</a>
                        <a href="#">Terms & Conditions</a>
                        <a href="#">Privacy Statement</a>
                    </div>
                    <div class="footer-col">
                        <h4>Payment methods</h4>
                        <div class="payment-icon">
                            <img src="{{ asset('/images/reservation-cards.png') }}">
                        </div>
                    </div>
                </div>
            </div>
            <p class="footer-copy">
                ©️2026 kredo POKECEBU
            </p>
        </footer>



        <style>
            /* フッター */
            .site-footer {
                background: #e7e9ec;
                padding: 60px 0 30px;
            }

            .footer-inner {
                max-width: 1000px;
                margin: auto;
                padding: 0 20px;
            }

            .footer-columns {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 40px;
            }

            .footer-col h4 {
                font-size: 15px;
                font-weight: 600;
                margin-bottom: 14px;
            }

            .footer-col a {
                display: block;
                font-size: 14px;
                color: #555;
                text-decoration: none;
                margin-bottom: 8px;
            }

            .footer-col a:hover {
                color: #000;
            }

            .payment-icon img {
                height: 26px;
                margin-right: 8px;
            }

            .footer-copy {
                text-align: center;
                font-size: 13px;
                color: #888;
                margin-top: 40px;
            }
        </style>
