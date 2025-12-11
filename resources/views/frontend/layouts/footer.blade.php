<div class="footer">
    <div class="container">
        <div class="row">



            <div class="footer-col-2">
                <h3>Contact & Follow Us</h3>
                <p><i class="fas fa-map-marker-alt"></i> Clifton, Karachi, Pakistan</p>
                <p><i class="fas fa-envelope"></i> info@trendurabags.com</p>

                <div class="social-links">
                    <!-- Social media links - Update with actual URLs when available -->
                    <!--
                    <a href="https://facebook.com/haulhaus" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/haulhaus" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i></a>
                    <a href="https://instagram.com/haulhaus" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                    <a href="https://wa.me/1234567890" target="_blank" rel="noopener noreferrer"><i class="fab fa-whatsapp"></i></a>
                    -->
                </div>
            </div>

            <!-- Column 2: Info Links (New class for styling) -->
            <div class="footer-col-info">
                <h3>Info</h3>
                <ul>
                    <li><a href="{{ url('returns') }}">Return and exchange policy</a></li>
                    <li><a href="{{ url('terms') }}">Terms of services</a></li>
                </ul>
            </div>

        </div>

        </div>

        <p class="copyright">&copy; 2025 Trendura Bags | All Rights Reserved</p>
    </div>
</div>
<script>
    // Auto-dismiss success alerts after 5 seconds across the site
    window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            document.querySelectorAll('.alert.alert-success, .auto-dismiss-success').forEach(el => {
                el.style.transition = 'opacity 0.4s ease';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            });
        }, 5000);
    });
</script>
@stack('scripts')
</body>
</html>
