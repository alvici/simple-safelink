    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-bottom">
                &copy; <?= date('Y'); ?> <?= htmlspecialchars(config('app_name'), ENT_QUOTES, 'UTF-8'); ?>. All rights reserved.
            </div>
        </div>
    </footer>

    <div class="toast" id="toast" role="status" aria-live="polite"></div>

    <script src="<?= asset_v('js/app.js'); ?>"></script>
</body>

</html>
