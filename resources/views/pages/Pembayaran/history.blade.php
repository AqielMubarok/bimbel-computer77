@extends('layouts.app')

@section('title', 'History Transaksi')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            @include('layouts.alert')

            <div class="row mt-5">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Jenis Paket</th>
                                            <th>Harga</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pembayarans as $pembayaran)
                                            <tr>
                                                <td>{{ $pembayaran->name }}</td>
                                                <td>{{ $pembayaran->jenis_paket }}</td>
                                                <td>Rp. {{ number_format($pembayaran->harga, 0, ',', '.') }}</td>
                                                <td>{{ $pembayaran->created_at->format('d M Y H:i') }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                    <a href="{{ route('pembayaran.print', $pembayaran->id) }}" class="btn btn-sm btn-primary mr-2">
                                                        <i class="fas fa-print"></i> Print
                                                    </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data transaksi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $pembayarans->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Event listener untuk tombol Print
        document.querySelectorAll('.btn-print').forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                // Ambil ID pembayaran (jika dibutuhkan)
                const pembayaranId = this.getAttribute('data-id');

                // Ambil elemen data baris
                const row = this.closest('tr');
                const nama = row.querySelector('td:nth-child(1)').innerText;
                const jenisPaket = row.querySelector('td:nth-child(2)').innerText;
                const harga = row.querySelector('td:nth-child(3)').innerText;
                const tanggalPembayaran = row.querySelector('td:nth-child(4)').innerText;

                // Buat konten untuk dicetak
                const printContent = `
                    <div style="font-family: Arial, sans-serif; margin: 20px;">
                        <h3>Detail Pembayaran</h3>
                        <p><strong>Nama:</strong> ${nama}</p>
                        <p><strong>Jenis Paket:</strong> ${jenisPaket}</p>
                        <p><strong>Harga:</strong> ${harga}</p>
                        <p><strong>Tanggal Pembayaran:</strong> ${tanggalPembayaran}</p>
                    </div>
                `;

                // Buka jendela baru untuk mencetak
                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Print Detail Pembayaran</title>
                        </head>
                        <body>
                            ${printContent}
                        </body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.print();
            });
        });
    });
</script>

@endpush