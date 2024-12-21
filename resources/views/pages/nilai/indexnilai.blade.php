@extends('layouts.app')

@section('title', 'Users')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Learning Module System</h1>
                <div class="section-header-breadcrumb">
                    <!-- Breadcrumb jika diperlukan -->
                </div>
            </div>
            <div class="section-body">
                @include('layouts.alert')

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <ul class="nav nav-pills">
                                <!-- Jika ada menu di sini, tambahkan item menu -->
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Nilai Peserta</h4>
                            </div>
                            
                            <div class="card-body">
                                @if(auth()->user()->rul == 'ADMIN' || auth()->user()->rul == 'PEMATERI')
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <form method="GET" action="{{ route('lihatnilai.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name" value="{{ request('name') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Nilai Tugas</th>
                                                <th>Nilai Ujian</th>
                                                <th>Predikat</th>
                                                <th>Kompetensi Unggulan</th>
                                                <th>Sertifikat</th> <!-- Tambahkan baris ini -->
                                                @if(auth()->user()->rul == 'ADMIN' || auth()->user()->rul == 'PEMATERI')
                                                <th>Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($nilais as $nilai)
                                                <tr>
                                                <td>{{ $nilai->name }}</td> <!-- Nama pengguna dari join tabel users -->
                                                <td>{{ $nilai->nilai_tugas ?? 'Belum Diisi' }}</td>
                                                <td>{{ $nilai->nilai_ujian ?? 'Belum Diisi' }}</td>
                                                <td>{{ $nilai->predikat ?? 'Belum Diisi' }}</td>
                                                <td>{{ $nilai->kompetensi_unggulan ?? 'Belum Diisi' }}</td>
                                                <td>
                                                    <a href="{{ route('nilai.downloadCertificate', $nilai->id) }}" class="btn btn-sm btn-primary btn-icon">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                <td>
                                                    @if(auth()->user()->rul == 'ADMIN' || auth()->user()->rul == 'PEMATERI')
                                                        <a href="{{ route('nilai.edit', $nilai->id) }}" class="btn btn-sm btn-info btn-icon mr-2">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('nilai.destroy', $nilai->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger btn-icon">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Tidak ada data untuk ditampilkan</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="float-right">
                                        {{ $nilais ->withQueryString()->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
