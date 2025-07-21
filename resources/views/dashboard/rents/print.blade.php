<!DOCTYPE html>
<html>
<head>
    <title>Print Data Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .kop-surat h1 {
            font-size: 24px;
            margin-bottom: 0;
        }
        .kop-surat p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- KOP SURAT -->
        <div class="kop-surat">
            <h1>UNIVERSITAS DUTA BANGSA</h1>
            <p>Jalan Bhayangkara No. 55 Tipes, Serengan, Kota Surakarta, Jawa Tengah</p>
            <p>Telp. (0271) 719552| Email: udb@ac.id</p>
        </div>

        <h3 class="text-center mb-4">Data Peminjaman Ruangan</h3>

        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Ruangan</th>
                    <th>Nama Peminjam</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Tujuan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($adminRents as $rent)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $rent->room->code }}</td>
                        <td>{{ $rent->user->name }}</td>
                        <td>{{ $rent->time_start_use }}</td>
                        <td>{{ $rent->time_end_use }}</td>
                        <td>{{ $rent->purpose }}</td>
                        <td>{{ $rent->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Penanggung Jawab -->
        <div class="mt-5">
            <div class="text-end">
                <p>Penanggung Jawab,</p>
                <br><br>
                <p><strong>{{ auth()->user()->name }}</strong></p>
            </div>
        </div>

        <div class="no-print text-center mt-4">
            <button onclick="window.print()" class="btn btn-primary">Print Sekarang</button>
        </div>
    </div>
</body>
</html>
