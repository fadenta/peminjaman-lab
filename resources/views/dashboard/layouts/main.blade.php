<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        xintegrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <title>{{ $title }} | Universitas Duta Bangsa </title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo-udb.png') }}">
</head>

<body>

    <div class="screen-cover d-none d-xl-none"></div>

    <div class="row">
        <div class="col-12 col-lg-3 col-navbar d-none d-xl-block">
            @include('dashboard.partials.sidebar')
        </div>

        <div class="col-12 col-xl-9">
            @include('dashboard.partials.navbar')

            {{-- ======================================================= --}}
            {{-- NOTIFIKASI --}}
            {{-- ======================================================= --}}
            @auth
                @php
                    $unreadNotifications = Auth::user()->notifications()->where('is_read', false)->get();
                @endphp

                @if ($unreadNotifications->isNotEmpty())
                    <div style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1055; width: 90%; max-width: 800px;">
                        @foreach ($unreadNotifications as $notification)
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow px-4 py-3 mb-3"
                                role="alert"
                                style="font-size: 1.1rem; border-left: 6px solid #3d72bcff; background-color: #e6f4ea; color: #155724;">
                                <i class="bi bi-check-circle-fill me-3 fs-4 text-success"></i>
                                <div class="flex-grow-1">
                                    <strong>Pemberitahuan:</strong> {{ $notification->message }}
                                </div>
                                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endforeach
                    </div>

                    @php
                        Auth::user()->notifications()->where('is_read', false)->update(['is_read' => true]);
                    @endphp
                @endif
            @endauth
            {{-- ======================================================= --}}
            {{-- END NOTIFIKASI --}}
            {{-- ======================================================= --}}

            @yield('container')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        xintegrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script>
        const navbar = document.querySelector('.col-navbar')
        const cover = document.querySelector('.screen-cover')
        const sidebar_items = document.querySelectorAll('.sidebar-item')

        function toggleNavbar() {
            navbar.classList.toggle('d-none')
            cover.classList.toggle('d-none')
        }

        function toggleActive(e) {
            sidebar_items.forEach(function(v, k) {
                v.classList.remove('active')
            })
            e.closest('.sidebar-item').classList.add('active')
        }

        // Auto-dismiss notifikasi setelah 10 detik
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 10000); // 10 detik
    </script>
</body>

</html>
