</main>
<footer class="site-footer">
    <div class="container footer-content">
        <div>
            <h3><?= e(APP_NAME); ?></h3>
            <p>Portfolio, products, and news managed with PHP and MySQL.</p>
        </div>
        <div class="footer-meta">
            <p>&copy; <?= date('Y'); ?> <?= e(APP_NAME); ?>. All rights reserved.</p>
        </div>
    </div>
</footer>
<script src="<?= e(app_url('js/main.js')); ?>" defer></script>
<script src="<?= e(app_url('js/slider.js')); ?>" defer></script>
<script src="<?= e(app_url('js/validation.js')); ?>" defer></script>
<script src="<?= e(app_url('js/auth-validation.js')); ?>" defer></script>
<script src="<?= e(app_url('js/contact-validation.js')); ?>" defer></script>
</div>
</body>
</html>
