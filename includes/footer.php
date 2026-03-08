        </div>
    </main>

    <footer class="py-4 mt-4">
        <div class="container-xxl">
            <div class="app-surface px-3 py-3 d-flex flex-wrap gap-2 align-items-center justify-content-between">
                <div class="text-muted small">
                    &copy; <?php echo date('Y'); ?> AURORA EHR System
                </div>
                <div class="text-muted small">
                    Secure Electronic Health Records
                </div>
            </div>
        </div>
    </footer>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize all tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
</body>
</html>