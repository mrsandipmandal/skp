<!doctype html>
<html lang="en" class=" layout-wide  customizer-hide" dir="ltr" data-skin="default"
    data-assets-path="{{ url('/') }}/assets/" data-template="vertical-menu-template" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>{{ config('app.name') }}: Not Authorized - Pages</title>
    <meta name="description"
        content="{{ config('app.name') }} is a platform for gaming enthusiasts to explore and enjoy various games." />
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5DDHKGP');
    </script>
    <link rel="icon" type="image/x-icon" href="{{ url('/') }}/assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ url('/') }}/assets/vendor/fonts/iconify-icons.css" />
    <link rel="stylesheet" href="{{ url('/') }}/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="{{ url('/') }}/assets/vendor/libs/pickr/pickr-themes.css" />
    <link rel="stylesheet" href="{{ url('/') }}/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/demo.css" />
    <link rel="stylesheet" href="{{ url('/') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ url('/') }}/assets/vendor/css/pages/page-misc.css" />
    <script src="{{ url('/') }}/assets/vendor/js/helpers.js"></script>
    <script src="{{ url('/') }}/assets/vendor/js/template-customizer.js"></script>
    <script src="{{ url('/') }}/assets/js/config.js"></script>
</head>
<body>
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0"
            style="display: none; visibility: hidden"></iframe>
    </noscript>
    <!-- Content -->
    <!-- Not Authorized -->
    <div class="misc-wrapper">
        <h1 class="mb-2 mx-2" style="font-size: 6rem;line-height: 6rem">401</h1>
        <h4 class="mb-2">You are not authorized! ?</h4>
        <p class="mb-10 mx-2">You don’t have permission to access this page. Go Home!</p>
        <div class="d-flex justify-content-center mt-5">
            <img src="{{ url('/') }}/assets/img/illustrations/tree-3.png" alt="misc-tree"
                class="img-fluid misc-object d-none d-lg-inline-block" />
            <img src="{{ url('/') }}/assets/img/illustrations/tree.png" alt="misc-tree"
                class="img-fluid misc-object-right d-none d-lg-inline-block" />
            <img src="{{ url('/') }}/assets/img/illustrations/misc-mask-light.png" alt="misc-error"
                class="scaleX-n1-rtl misc-bg d-none d-lg-inline-block" height="172"
                data-app-light-img="illustrations/misc-mask-light.png"
                data-app-dark-img="illustrations/misc-mask-dark.png" />
            <div class="d-flex flex-column align-items-center">
                <img src="{{ url('/') }}/assets/img/illustrations/401.png" alt="misc-error"
                    class="misc-model img-fluid z-1" width="780" />
                <div>
                    <a href="{{ url('/') }}" class="btn btn-primary text-center my-6">Back to home</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Not Authorized -->
    <!-- / Content -->
    <script src="{{ url('/') }}/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ url('/') }}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ url('/') }}/assets/vendor/js/bootstrap.js"></script>
    <script src="{{ url('/') }}/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="{{ url('/') }}/assets/vendor/libs/@algolia/autocomplete-js.js"></script>
    <script src="{{ url('/') }}/assets/vendor/libs/pickr/pickr.js"></script>
    <script src="{{ url('/') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{ url('/') }}/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="{{ url('/') }}/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="{{ url('/') }}/assets/vendor/js/menu.js"></script>
    <script src="{{ url('/') }}/assets/js/main.js"></script>
</body>
</html>
