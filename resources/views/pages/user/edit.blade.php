@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Crypt;
@endphp

@section('title', 'New User')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>New User</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Users</a></div>
                    <div class="breadcrumb-item">New User</div>
                </div>
            </div>

            <div class="section-body">

                <div class="card">
                    <form action="{{ route('user.update', ['user' => Crypt::encrypt($user->id)]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h4>New User</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text"
                                    class="form-control @error('name')
                                    is-invalid
                                @enderror"
                                    name="name" value="{{ $user->name }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" value="{{ $user->email }}"
                                    class="form-control @error('email')
                                    is-invalid
                                @enderror"
                                    name="email">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number"  value="{{ $user->phone }}"
                                    class="form-control @error('phone')
                                    is-invalid
                                @enderror"
                                    name="phone">
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Position</label>
                                <input type="text" class="form-control" name="position" value="{{ $user->position }}"
                                class="form-control @error('position')
                                    is-invalid
                                @enderror"
                                    name="position">
                                @error('position')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" value="{{ $user->address }}"
                                class="form-control @error('address')
                                    is-invalid
                                @enderror"
                                    name="address">
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-group">
                                <label>Divisi</label>
                                <input type="text" class="form-control" name="divisi" value="{{ $user->divisi }}"
                                class="form-control @error('divisi')
                                    is-invalid
                                @enderror"
                                    name="divisi">
                                @error('divisi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="form-group">
                                <label class="form-label">Roles</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="rul" value="ADMIN" class="selectgroup-input"
                                            @if ($user->rul == 'ADMIN') checked @endif>
                                        <span class="selectgroup-button">Admin</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="rul" value="PEMATERI" class="selectgroup-input"
                                        @if ($user->rul == 'PEMATERI') checked @endif>
                                        <span class="selectgroup-button">Pemateri</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="rul" value="PESERTA" class="selectgroup-input"
                                        @if ($user->rul == 'PESERTA') checked @endif>
                                        <span class="selectgroup-button">Peserta</span>
                                    </label>

                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
