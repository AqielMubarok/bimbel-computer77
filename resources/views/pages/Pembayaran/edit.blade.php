
@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Crypt;
@endphp

@section('title', 'Form Pembayaran')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Pembayaran</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
<div class="container">
    <h2>Edit Status Pembayaran</h2>
    <form action="{{ route('pembayaran.update', Crypt::encrypt($pembayaran->id)) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="Rejected" {{ $pembayaran->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="Approved" {{ $pembayaran->status == 'Approved' ? 'selected' : '' }}>Approved</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
