@extends('layouts.app')

@section('title', 'Form Pembayaran')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Pembayaran</h1>
            </div>

            {{-- Alert Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="payment-method-info">
                            <div class="images">
                                <img src="{{ asset('img/payment/visa.png') }}" alt="visa">
                                <img src="{{ asset('img/payment/mastercard.png') }}" alt="mastercard">
                            </div>
                            <div></div>
                            
                            <p>
                                <h4>Metode Pembayaran: Transfer rekening BRI</h4>
                            </p>
                        </div>

                        <div class="d-flex align-items-center">
                            <p>
                                <h3>Nomor Rekening: 500601035093536 (A/N Rosmayanti Tinti)</h3>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    name="name" value="{{ auth()->user()->name }}" readonly>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="no_telp">Nomor Telepon</label>
                                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" 
                                    name="no_telp" value="{{ auth()->user()->phone }}" readonly>
                                @error('no_telp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ auth()->user()->email }}" readonly>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jenis_paket">Jenis Paket</label>
                                <input type="text" name="jenis_paket" value="{{ $paket }}" class="form-control" readonly>
                            </div>

                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="text" id="formatted-harga" value="{{ number_format($harga, 0, ',', '.') }}" 
                                    class="form-control" readonly>
                                <input type="hidden" name="harga" value="{{ $harga }}">
                            </div>

                            <div class="form-group">
                                <label for="struk">Bukti Struk Transfer</label>
                                <input type="file" class="form-control @error('struk') is-invalid @enderror"
                                    name="struk" id="struk" accept="image/*,application/pdf" required>
                                <small class="form-text text-muted">Unggah file bukti struk transfer (jpg, jpeg, png, pdf). Maksimal 2MB.</small>
                                @error('struk')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="text-md-right">
                                <div class="float-lg-left mb-lg-0 mb-3">
                                    <button type="submit" class="btn btn-primary btn-icon icon-left">
                                        <i class="fas fa-credit-card"></i> Process Pembayaran
                                    </button>
                                    <a href="{{ route('pages.Pembayaran.paket') }}" class="btn btn-danger btn-icon icon-left">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('styles')
    <style>
        .alert {
            margin-bottom: 20px;
            border-radius: 4px;
            position: relative;
            padding: 0.75rem 1.25rem;
        }
        .alert-dismissible .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: 0.75rem 1.25rem;
            color: inherit;
        }
        .payment-method-info {
            margin-bottom: 20px;
        }
        .payment-method-info .images {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        .payment-method-info .images img {
            height: 30px;
            object-fit: contain;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Handle form submission
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            var formattedHarga = document.getElementById('formatted-harga').value;
            var harga = document.querySelector('input[name="harga"]');
            
            // Remove thousand separators and convert to plain number
            var hargaNumeric = formattedHarga.replace(/[^\d]/g, '');
            harga.value = hargaNumeric;
        });

        // Validate file size before upload
        document.getElementById('struk').addEventListener('change', function() {
            const fileSize = this.files[0].size / 1024 / 1024; // in MB
            if (fileSize > 2) {
                alert('File terlalu besar. Maksimal ukuran file adalah 2MB');
                this.value = ''; // Clear the input
            }
        });

        // Auto hide alert after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    alert.classList.remove('show');
                    setTimeout(function() {
                        alert.remove();
                    }, 150);
                });
            }, 5000);
        });
    </script>
    @endpush
@endsection