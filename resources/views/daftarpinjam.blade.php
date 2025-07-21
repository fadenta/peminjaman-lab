@extends('layouts.main')

@section('container')
    <div class="preloader">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="blog" class="blog-area pt-170 pb-140">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-7">
                    <div class="section-title">
                        <h2 class="wow fadeInUp" data-wow-delay=".2s">{{ $title }}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".4s">
                            Pemberitahuan dari admin akan muncul di daftar
                            peminjaman ini. Silahkan tunggu sampai dapat persetujuan dari admin.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10 p-0">
                    <div class="card-body">

                        <div class="table-responsive justify-content-center mt-4">
                            <div class="d-flex justify-content-end">
                                {{ $userRents->links() }}
                            </div>

                            <table class="fl-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode Ruangan</th>
                                        <th>Nama Peminjam</th>
                                        <th>Mulai Pinjam</th>
                                        <th>Selesai Pinjam</th>
                                        <th>Tujuan</th>
                                        <th>Waktu Transaksi</th>
                                        <th>Kembalikan</th>
                                        <th>Status Pinjam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($userRents->count() > 0)
                                        @foreach ($userRents as $rent)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td><a href="/showruang/{{ $rent->room->code }}" class="text-decoration-none">{{ $rent->room->code }}</a></td>
                                                <td>{{ $rent->user->name }}</td>
                                                <td>{{ $rent->time_start_use }}</td>
                                                <td>{{ $rent->time_end_use }}</td>
                                                <td>{{ $rent->purpose }}</td>
                                                <td>{{ $rent->transaction_start }}</td>
                                                <td>{{ $rent->transaction_end ?? '-' }}</td>
                                                <td>{{ $rent->status }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center">-- Belum Ada Peminjaman --</td>
                                        </tr>
                                    @endif
                                <tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection