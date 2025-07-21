@extends('layouts.main')

@section('container')
    <!--====== Daftar Ruang ======-->
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
                        <h2 class="wow fadeInUp" data-wow-delay=".2s">Daftar Laboratorium</h2>
                        <p class="wow fadeInUp" data-wow-delay=".4s">Pesan Ruang dengan Lebih Mudah! Kami menyediakan solusi
                            peminjaman ruang yang praktis untuk mahasiswa dan staf universitas. Peminjaman Lab hanya bisa dilakukan di Sistem</p>
                    </div>
                </div>
            </div>
            <div class="row">
                
                @foreach ($rooms as $room)
                   <div class="col-xl-4 col-lg-4 col-md-6">
    <div class="single-blog">
        <div class="blog-img">
            {{-- LINK GAMBAR KITA BUAT KONDISIONAL --}}
            @if ($room->status_display == 'Sedang Dipinjam')
            {{-- Jika dipinjam, link tidak aktif dan memunculkan notifikasi saat diklik --}}
            <a href="#" onclick="alert('Maaf, ruangan sedang dipinjam.'); return false;">
                @if ($room->img && Storage::exists('public/' . $room->img))
                <img src="{{ asset('storage/' . $room->img) }}" alt="">
                    @elseif ($room->img)
                    <img src="{{ $room->img }}" alt="FotoRuang">
                        @endif
                    </a>
                    @else
                    {{-- Jika kosong, link normal ke halaman detail --}}
                    <a href="/showruang/{{ $room->code }}">
                        @if ($room->img && Storage::exists('public/' . $room->img))
                        <img src="{{ asset('storage/' . $room->img) }}" alt="">
                            @elseif ($room->img)
                            <img src="{{ $room->img }}" alt="FotoRuang">
                                @endif
                            </a>
                            @endif
                        </div>
                        <div class="blog-content">
                            {{-- LINK JUDUL JUGA KITA BUAT KONDISIONAL --}}
                            <h4>
                                @if ($room->status_display == 'Sedang Dipinjam')
                                <a href="#" onclick="alert('Maaf, ruangan sedang dipinjam.'); return false;">{{ $room->name }}</a>
                                @else
                                <a href="/showruang/{{ $room->code }}">{{ $room->name }}</a>
                                @endif
                            </h4>
                            <p>Gedung :
                                {{ $room->building->name }}</p>
                            <p>Kapasitas :
                                {{ $room->capacity }}</p>
                            {{-- Ini adalah status yang sudah kita tambahkan sebelumnya --}}
                            <p>
                                <span class="badge {{ $room->status_class }}">{{ $room->status_display }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                    
                @endforeach
                <div class="d-flex justify-content-end">
                    {{ $rooms->links() }}
                </div>
            </div>


        </div>
    </section>

    
    <!--====== Daftar Ruang ======-->
@endsection
