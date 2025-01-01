@extends('layouts.app')

@section('title', 'Pricing')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Paket Bimbel</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Pricing</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Harga Bimbel</h2>
            <div class="row justify-content-center -mt-10">

                <!-- Kelas Premium -->
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="pricing pricing-highlight">
                        <div class="pricing-title-premium">
                            Kelas Premium
                        </div>
                        <div class="pricing-padding">
                            <div class="pricing-price">
                                <div>Rp 1.200.000</div>
                                <div>per 3 Bulan</div>
                            </div>
                            <div class="pricing-details">
                                <div class="pricing-item">
                                    <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                    <div class="pricing-item-label">Pembelajaran Lebih Lama dengan Harga yang Lebih Murah</div>
                                </div>
                                <div class="pricing-item">
                                    <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                    <div class="pricing-item-label">Dibuatkan Sertifikat</div>
                                </div>
                                <div class="pricing-item">
                                    <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                    <div class="pricing-item-label">Mendapatkan Bimbingan Personal</div>
                                </div>
                                <div class="pricing-item">
                                    <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                    <div class="pricing-item-label">Akses Materi dari dasar hingga mahir</div>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-cta">
                            <!-- Form untuk melakukan pembayaran -->
                            <form action="{{ route('form.bayar') }}" method="GET">
                                @php
                                    // Data paket
                                    $paket = 'Premium';
                                    $harga = 1200000;

                                    // Hash untuk validasi integritas data
                                    $hash = hash_hmac('sha256', "$paket|$harga", env('APP_KEY'));

                                    // Enkripsi data
                                    $encryptedData = encrypt(json_encode(['paket' => $paket, 'harga' => $harga, 'hash' => $hash]));
                                @endphp
                                <input type="hidden" name="data" value="{{ $encryptedData }}">
                                <button type="submit" class="btn btn-primary-pesan">Pesan Paket {{ $paket }}</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Kelas Standar -->
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="pricing pricing-highlight">
                        <div class="pricing-title-standar">
                            Kelas Standar
                        </div>
                        <div class="pricing-padding">
                            <div class="pricing-price">
                                <div>Rp 500.000</div>
                                <div>per bulan</div>
                            </div>
                            <div class="pricing-details">
                                <div class="pricing-item">
                                    <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                    <div class="pricing-item-label">Akses Materi Pembelajaran Dasar hingga Menengah</div>
                                </div>
                                <div class="pricing-item">
                                    <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                    <div class="pricing-item-label">Hanya dibuatkan Nilai tanpa Sertifikat</div>
                                </div>
                                <div class="pricing-item">
                                    <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                    <div class="pricing-item-label">Solusi Hemat bagi Siswa yang Ingin Cepat Siap</div>
                                </div>
                                <div class="pricing-item">
                                    <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                    <div class="pricing-item-label">Cocok untuk Belajar dengan Tujuan Tertentu</div>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-cta">
                            <!-- Form untuk melakukan pembayaran -->
                            <form action="{{ route('form.bayar') }}" method="GET">
                                @php
                                    // Data paket
                                    $paket = 'Standar';
                                    $harga = 500000;

                                    // Hash untuk validasi integritas data
                                    $hash = hash_hmac('sha256', "$paket|$harga", env('APP_KEY'));

                                    // Enkripsi data
                                    $encryptedData = encrypt(json_encode(['paket' => $paket, 'harga' => $harga, 'hash' => $hash]));
                                @endphp
                                <input type="hidden" name="data" value="{{ $encryptedData }}">
                                <button type="submit" class="btn btn-primary-pesan">Pesan Paket {{ $paket }}</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection
