<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Learning module sistem</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">Course</a>
        </div>
        <ul class="sidebar-menu">


            <ul class="sidebar-menu">
  @if(auth()->user()->rul == 'ADMIN')
<li class="nav-item dropdown ">
    <a href="#" class="nav-link has-dropdown"> <i class="fas fa-fire"></i><span>User</span></a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link" href="{{route('user.index')}}">Tambah User</a>
        </li>

    </ul>
</li>
@endif
@if(auth()->user()->rul == 'ADMIN' | auth()->user()->rul == 'PEMATERI')
<li class="nav-item dropdown ">
    <a href="#" class="nav-link has-dropdown"> <i class="fas fa-fire"></i><span>Pemateri</span></a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link" href="{{route('lecturer.index')}}">Tambah Kelas</a>
            @endif
            @if(auth()->user()->rul == 'PESERTA')
            <li class="nav-item dropdown ">
            
            <a href="{{route('lecturer.index')}}" class=""> <i class="fas fa-fire"></i><span>Materi</span></a>
            @endif
        </li>

    </ul>
</li>

@if(auth()->user()->rul == 'ADMIN' || auth()->user()->rul == 'PEMATERI')
<li class="nav-item dropdown ">
    <a href="" class="nav-link has-dropdown"> <i class="fas fa-fire"></i><span>Absensi</span></a>
    <ul class="dropdown-menu">
        <li>
            <a class="nav-link" href="{{ route('absensi.index') }}">Absensi peserta</a>
            
        </li>

    </ul>
</li>
@endif



<li class="nav-item dropdown ">
    <a href="#" class="nav-link has-dropdown"> <i class="fas fa-fire"></i><span>Tugas</span></a>
    <ul class="dropdown-menu">
        
        <li>
        @if(auth()->user()->rul == 'ADMIN' || auth()->user()->rul == 'PEMATERI')
            <a class="nav-link" href="{{ route('tugas.create') }}">upload soal </a>
            @endif
           
           
       
        <li>
       
            <a class="nav-link" href="{{route('tugas.index')}}"> lihat tugas </a>
           
           
           
        </li>
        </li>
        
        <li>
        @if(auth()->user()->rul == 'PESERTA')
            <a class="nav-link" href=""> Upload Tugas </a>
            @endif
           
           
        </li>

    </ul>
    <li class="nav-item dropdown ">
    <a href="#" class="nav-link has-dropdown"> <i class="fas fa-fire"></i><span>Nilai</span></a>
    <ul class="dropdown-menu">
        <li>
        @if(auth()->user()->rul == 'ADMIN' || auth()->user()->rul == 'PEMATERI')
            <a class="nav-link" href="">Input nilai</a>
            @endif
            @if(auth()->user()->rul == 'ADMIN')
            <a class="nav-link" href="">Report nilai</a>
            @endif
           
        </li>

    </ul>
</li>
<li class="nav-item dropdown ">
@if(auth()->user()->rul == 'ADMIN')
    <a href="#" class="nav-link has-dropdown"> <i class="fas fa-fire"></i><span>Laporan</span></a>@endif
    <ul class="dropdown-menu">

        <li>
        @if(auth()->user()->rul == 'ADMIN')
            <a class="nav-link" href="">Pendaftaran Peserta</a>
            @endif
            
           
            <a class="nav-link" href="{{route('pages.Pembayaran.index') }}">Pembayaran Bimbel</a>
           
           
        </li>

    </ul>
    <li class="nav-item dropdown ">
@if(auth()->user()->rul == 'PESERTA')
    <a href="#" class="nav-link has-dropdown"> <i class="fas fa-fire"></i><span>Transaksi</span></a>@endif
    <ul class="dropdown-menu">

        <li>
        @if(auth()->user()->rul == 'PESERTA')
            <a class="nav-link" href="">Bimbel</a>
            @endif
            
           
           
           
        </li>

    </ul>
</li>

<li class="nav-item dropdown ">
       
    <a href="#" class="nav-link has-dropdown"> <i class="fas fa-fire"></i><span>Settings</span></a>
    <ul class="dropdown-menu">    
        <li>          
        
           
        </li>

        
</li>

            

    </aside>
    



</div>
