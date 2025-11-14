<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
            <div class="mb-2 mb-md-0">
                Copyright &copy; {{ date('Y') }}
                <a href="{{ url('/') }}" class="link-secondary">{{ config('app.name') }}</a>.
                All rights reserved.
            </div>
            <!--
                    <div class="d-none d-lg-inline-block">
                    <a
                      href="https://themeselection.com/item/category/admin-templates/"
                      target="_blank"
                      class="footer-link me-4"
                      >Admin Templates</a
                    >
                    <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                    <a
                      href="https://themeselection.com/item/category/bootstrap-templates/"
                      target="_blank"
                      class="footer-link me-4"
                      >Bootstrap Templates</a
                    >
                    <a
                      href="https://demos.themeselection.com/materio-bootstrap-html-admin-template/documentation/"
                      target="_blank"
                      class="footer-link me-4"
                      >Documentation</a
                    >
                    <a
                      href="https://github.com/themeselection/materio-bootstrap-html-admin-template-free/issues"
                      target="_blank"
                      class="footer-link"
                      >Support</a
                    >
                  </div>
                -->
        </div>
    </div>
</footer>
<!-- / Footer -->
<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>
<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->
<!-- Core JS -->
<script src="{{ url('/') }}/assets/vendor/libs/jquery/jquery.js"></script>
<script src="{{ url('/') }}/assets/vendor/libs/popper/popper.js"></script>
<script src="{{ url('/') }}/assets/vendor/js/bootstrap.js"></script>
<script src="{{ url('/') }}/assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="{{ url('/') }}/assets/vendor/libs/@algolia/autocomplete-js.js"></script>
<script src="{{ url('/') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="{{ url('/') }}/assets/vendor/js/menu.js"></script>
<script src="{{ url('/') }}/assets/vendor/js/helpers.js"></script>
<script src="{{ url('/') }}/assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="{{ url('/') }}/assets/js/main.js"></script>
<script src="{{ url('/') }}/assets/js/dashboards-analytics.js"></script>
<script src="{{ url('/') }}/assets/js/form-wizard-numbered.js"></script>
<script src="{{ url('/') }}/assets/js/form-wizard-validation.js"></script>
<script src="{{ url('/') }}/assets/vendor/libs/@form-validation/auto-focus.js"></script>
<script async="async" defer="defer" src="https://buttons.github.io/buttons.js"></script>
<script src="{{ url('/') }}/dist/js/select2.min.js"></script>
<script src="{{ url('/') }}/dist/js/sweetalert2.all.min.js"></script>
<script>
    $('.select2').select2();

    function isNumber(evt) {
        var iKeyCode = evt.which ? evt.which : evt.keyCode;
        if (iKeyCode < 48 || iKeyCode > 57) {
            return false;
        }
        return true;
    }

    function isNumberDot(evt) {
        evt = evt ? evt : window.event;
        var charCode = evt.which ? evt.which : evt.keyCode;
        if (
            charCode > 31 &&
            (charCode < 48 || charCode > 57) &&
            (charCode > 45 || charCode < 45) &&
            (charCode > 46 || charCode < 46)
        ) {
            return false;
        }
        return true;
    }
</script>
</body>

</html>
