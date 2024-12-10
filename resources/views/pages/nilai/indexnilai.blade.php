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
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <form method="GET" action="{{ route('nilai.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name" value="{{ request('name') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Kehadiran</th>
                                                <th>Kompetensi</th>
                                                <th>Skill</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($nilais as $user)
                                                <tr>
                                                    <td>{{ $user->name }}</td> <!-- Nama dari tabel users -->
                                                    <td>{{ $user->kehadiran ?? 'Belum Diisi' }}</td> <!-- Kehadiran dari tabel nilais -->
                                                    <td>{{ $user->kompetensi ?? 'Belum Diisi' }}</td> <!-- Kompetensi -->
                                                    <td>{{ $user->skill ?? 'Belum Diisi' }}</td> <!-- Skill -->
                                                    <td>{{ $user->status ?? 'Belum Diisi' }}</td> <!-- Status -->
                                                    <td>
                                                        <a href="" class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i> Edit 
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data untuk ditampilkan</td>
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