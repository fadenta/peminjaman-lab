<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $title }} | Universitas Duta Bangsa</title>
    <meta name="description" content="">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo-udb.png') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/LineIcons.2.0.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-5.0.5-alpha.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
</head>

<body>

    @include('partials.navbar')

    {{-- ============================================ --}}
    {{-- NOTIFIKASI BESAR DI TENGAH ATAS --}}
    {{-- ============================================ --}}
    @auth
        @php
            $unreadNotifications = Auth::user()->notifications()->where('is_read', false)->get();
        @endphp

        @if ($unreadNotifications->isNotEmpty())
            <div style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050; width: 600px;">
                @foreach ($unreadNotifications as $notification)
                    <div class="alert alert-success alert-dismissible fade show shadow-lg fs-5 text-center" role="alert" style="padding: 1.5rem 2rem;">
                        <strong>✅ Notifikasi:</strong> {{ $notification->message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="top: 1rem; right: 1rem;"></button>
                    </div>
                @endforeach
            </div>

            @php
                Auth::user()->notifications()->where('is_read', false)->update(['is_read' => true]);
            @endphp
        @endif
    @endauth

    {{-- ISI HALAMAN --}}
    @yield('container')

    {{-- FOOTER --}}
    @if (request()->path() !== 'login')
        @include('partials.footer')
    @endif

    {{-- JS --}}
    <script src="{{ asset('assets/js/bootstrap.bundle-5.0.0.alpha-min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    {{-- Auto close alert after 6 seconds --}}
    <script>
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 6000);
    </script>

    {{-- Smooth Scroll --}}
    <script>
        var pageLink = document.querySelectorAll('.page-scroll');
        pageLink.forEach(elem => {
            elem.addEventListener('click', e => {
                e.preventDefault();
                const target = document.querySelector(elem.getAttribute('href'));
                if (target) {
                    const yOffset = -60;
                    const y = target.getBoundingClientRect().top + window.pageYOffset + yOffset;
                    window.scrollTo({ top: y, behavior: 'smooth' });
                }
            });
        });

        function onScroll(event) {
            var sections = document.querySelectorAll('.page-scroll');
            var scrollPos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
            for (var i = 0; i < sections.length; i++) {
                var currLink = sections[i];
                var val = currLink.getAttribute('href');
                var refElement = document.querySelector(val);
                var scrollTopMinus = scrollPos + 73;
                if (refElement.offsetTop <= scrollTopMinus &&
                    (refElement.offsetTop + refElement.offsetHeight > scrollTopMinus)) {
                    document.querySelector('.page-scroll').classList.remove('active');
                    currLink.classList.add('active');
                } else {
                    currLink.classList.remove('active');
                }
            }
        }
        window.document.addEventListener('scroll', onScroll);

        let navbarToggler = document.querySelector(".navbar-toggler");
        var navbarCollapse = document.querySelector(".navbar-collapse");
        document.querySelectorAll(".page-scroll").forEach(e =>
            e.addEventListener("click", () => {
                navbarToggler.classList.remove("active");
                navbarCollapse.classList.remove('show');
            })
        );
        navbarToggler.addEventListener('click', function () {
            navbarToggler.classList.toggle("active");
        });

        function togglePassword() {
            var x = document.getElementById("password-content-3-6");
            if (x.type === "password") {
                x.type = "text";
                document.getElementById("icon-toggle").setAttribute("fill", "#2ec49c");
            } else {
                x.type = "password";
                document.getElementById("icon-toggle").setAttribute("fill", "#CACBCE");
            }
        }
    </script>

    {{-- Bootstrap CDN fallback --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous">
    </script>

</body>

</html>
