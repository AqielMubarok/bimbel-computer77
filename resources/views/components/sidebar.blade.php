<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('home')}}">Learning module sistem</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">Course</a>
        </div>
        <ul class="sidebar-menu">

            {{-- Menu untuk ADMIN --}}
            @if(auth()->user()->rul == 'ADMIN')
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-users"></i><span>User</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('user.index') }}">Tambah User</a>
                    </li>
                </ul>
            </li>
            @endif

            {{-- Menu untuk ADMIN dan PEMATERI --}}
            @if(auth()->user()->rul == 'ADMIN' || auth()->user()->rul == 'PEMATERI')
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-school"></i><span>Pemateri</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('lecturer.index') }}">Tambah Materi</a>
                    </li>
                </ul>
            </li>
            @endif

            {{-- Menu untuk PESERTA --}}
            @if(auth()->user()->rul == 'PESERTA')
                @php
                    $pembayaran = App\Models\Pembayaran::whereHas('user', function ($query) {
                        $query->where('name', auth()->user()->name);
                    })->first();
                @endphp

                @if($pembayaran && $pembayaran->status == 'Approved')
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link has-dropdown">
                            <i class="fas fa-book"></i><span>Materi</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="nav-link" href="{{ route('lecturer.index') }}">Lihat Materi</a>
                            </li>
                        </ul>
                    </li>
                @else
                <li class="nav-item">
                <a  class="nav-link text-muted" href ="{{ route('pages.Pembayaran.paket')}}">
                    <i class="fas fa-lock"></i><span>Materi (Terkunci)</span>
                </a>
            </li>
                @endif
            @endif

            {{-- Menu untuk Tugas --}}
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-book"></i><span>Tugas</span>
                </a>
                <ul class="dropdown-menu">
                    @if(auth()->user()->rul == 'ADMIN' || auth()->user()->rul == 'PEMATERI')
                    <li>
                        <a class="nav-link" href="{{ route('tugas.create') }}">Upload Tugas</a>
                    </li>
                    @endif

                    <li>

    {{-- Jika pengguna adalah PESERTA, hanya dapat mengakses jika sudah membayar --}}

    @if(auth()->user()->rul == 'PESERTA' && $pembayaran && $pembayaran->status == 'Approved')
        <a class="nav-link" href="{{ route('tugas.index') }}">Lihat Tugas</a>
    {{-- Jika pengguna adalah ADMIN atau PEMATERI, tidak perlu validasi pembayaran --}}
    @elseif(auth()->user()->rul == 'ADMIN' || auth()->user()->rul == 'PEMATERI')
        <a class="nav-link" href="{{ route('tugas.index') }}">Lihat Tugas Anda</a>

   
    @endif
    
    
</li>

<li>
    {{-- Jika pengguna adalah PESERTA, hanya dapat mengakses jika sudah membayar --}}

    @if(auth()->user()->rul == 'PESERTA' && $pembayaran && $pembayaran->status == 'Approved')
        <a class="nav-link" href="{{ route('kumpul.create') }}">Kumpul Tugas</a>
    {{-- Jika pengguna adalah ADMIN atau PEMATERI, tidak perlu validasi pembayaran --}}
    @elseif(auth()->user()->rul == 'ADMIN')
    <a class="nav-link" href="{{ route('kumpul.create') }}">Kumpul Tugas</a>
    @endif
    @if(auth()->user()->rul == 'ADMIN' || auth()->user()->rul == 'PEMATERI')
    <a class="nav-link" href="{{ route('kumpul.index') }}">Lihat Tugas Peserta</a>
    @endif
    
</li>
                </ul>
            </li>

            {{-- Menu untuk Nilai --}}
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-star"></i><span>Nilai</span>
                </a>
                <ul class="dropdown-menu">
                    @if(auth()->user()->rul == 'ADMIN' || auth()->user()->rul == 'PEMATERI')
                    <li>
                        <a class="nav-link" href="{{route('nilai.index')}}">Input Nilai</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{route('lihatnilai.index')}}">Lihat Nilai</a>
                    </li>
                    @endif
                    @if(auth()->user()->rul == 'PESERTA' && $pembayaran && $pembayaran->status == 'Approved')
                    <li>
                        <a class="nav-link" href="{{route('lihatnilai.index')}}">Lihat Nilai</a>
                    </li>
                    @endif
                </ul>
            </li>

            {{-- Menu untuk Laporan (ADMIN) --}}
            @if(auth()->user()->rul == 'ADMIN')
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-folder"></i><span>Laporan</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('pembayaran.index') }}">Pembayaran Bimbel</a>
                    </li>
                </ul>
            </li>
            @endif

            {{-- Menu untuk Transaksi (PESERTA) --}}
            @if(auth()->user()->rul == 'PESERTA')
            <li class="nav-item dropdown">
                <a class="nav-link has-dropdown" href="">
                    <i class="fas fa-shopping-cart"></i><span>History Transaksi</span>
                </a>
                <ul class="dropdown-menu">
                    @if(auth()->user()->rul == 'PESERTA' && $pembayaran && $pembayaran->status == 'Approved')
                    <li>
                        <a class="nav-link" href="{{ route('pembayaran.history') }}">Pembayaran</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

        </ul>
    </aside>
</div>
