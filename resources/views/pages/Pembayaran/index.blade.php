@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Crypt;
@endphp


@section('title', 'Users')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Learning module system</h1>
               
                <div class="section-header-breadcrumb">
                   
                </div>
            </div>
            <div class="section-body">
                
            @include('layouts.alert')

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <div class="card-body">
                                <ul class="nav nav-pills">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                           
                                <h4>All Posts</h4>
                            </div>
                           
                                <div class="card-body">
                                <div class="float-left">
</div>
                                <a href="{{ route('Pembayaran.export') }}" class="btn btn-success">Export to Excel</a>
                                </div>
                                </div>
                                <div class="float-right">
                                    <form method="GET" action="{{ route('pembayaran.index') }}">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control"
                                                placeholder="Search" name="name">
                                                
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>

                                            <th>Name</th>
                                            <th>No Telp</th>
                                            <th>Email</th>
                                            <th>Jenis Paket</th>
                                            <th>Harga</th>
                                            <th>Status</th>
                                            <th>Struk</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($pembayarans as $pembayaran)
                                            <tr>
                                            <td>
                                            {{ $pembayaran->name }}
                                            </td>
                                            <td>
                                            {{ $pembayaran->no_telp }}
                                            </td>
                                            <td>
                                            {{ $pembayaran->email }}
                                            </td>
                                            <td>
                                            {{ $pembayaran->jenis_paket }}
                                            </td>
                                            <td>
                                            {{ $pembayaran-> harga }}
                                            </td>
                                            <td>
                                            {{ $pembayaran->status }}
                                            </td>
                                            <td>
                                            {{ $pembayaran->struk }}
                                            </td>
                                            <td>
                                            {{ $pembayaran->tanggal_pembayaran }}
                                            </td>
                                          
                                            <td>
                                               
                                            <div class="d-flex justify-content-center">
                                            <a href="{{route('formbayar.download',$pembayaran->id)}}" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-download"></i> Download
                                                                </a>
                                                                
                                                            <a href="{{ route('pembayaran.edit', Crypt::encrypt($pembayaran->id)) }}"
                                                                class="btn btn-sm btn-info btn-icon">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>


                                                        <form onclick="return confirm('are you sure ? ')"  class="d-inline" action=" {{ route('pembayaran.destroy', $pembayaran->id) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure?')" class="d-inline"   class="ml-2">
                                                            <input type="hidden" name="_method" value="DELETE" />
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}" />
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                        
                                                        <!-- Modal Konfirmasi Penghapusan -->

                                                        <!-- ====== -->
                                                    </div>
                                            </td>
                                        </tr>
                                        @endforeach
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
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
