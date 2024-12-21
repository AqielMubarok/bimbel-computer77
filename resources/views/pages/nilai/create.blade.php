@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Crypt;
@endphp

@section('title', 'Edit Nilai Peserta Bimbel')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Nilai Peserta Bimbel</h1>
            </div>

            <div class="section-body">
                <div class="card">
                <form action="{{ isset($nilai) ? route('nilai.update', $nilai->id) : route('nilai.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($nilai))
                            @method('PUT')
                        @endif

                        <input type="hidden" name="user_id" value="{{ $user->id }}"> <!-- Tetap gunakan ID peserta -->

                        <div class="card-header">
                            <h4>{{ isset($nilai) ? 'Edit Nilai Peserta' : 'Tambah Nilai Peserta' }}</h4>
                        </div>
                        <div class="card-body">
                            <!-- Peserta Bimbel -->
                            <div class="form-group">
                                <label for="user_name">Peserta Bimbel</label>
                                <input 
                                    type="text" 
                                    name="user_name" 
                                    id="user_name" 
                                    value="{{ $user->name }}" 
                                    class="form-control" 
                                    readonly>
                            </div>

                            <!-- Kehadiran -->
                            <div class="form-group">
                                <label for="nilai_tugas">Nilai Tugas</label>
                                <input 
                                    type="text" 
                                    name="nilai_tugas" 
                                    id="nilai_tugas" 
                                    placeholder="Nilai Tugas"
                                    class="form-control @error('nilai_tugas') is-invalid @enderror"
                                    value="{{ old('nilai_tugas', isset($nilai) ? $nilai->nilai_tugas : '') }}">
                            </div>

                            <!-- Kompetensi -->
                            <div class="form-group">
                                <label for="nilai_ujian">Nilai Ujian</label>
                                <input 
                                    type="text" 
                                    name="nilai_ujian" 
                                    id="nilai_ujian" 
                                    placeholder="Nilai Ujian"
                                    class="form-control @error('nilai_ujian') is-invalid @enderror"
                                    value="{{ old('nilai_ujian', isset($nilai) ? $nilai->nilai_ujian : '') }}">
                            </div>

                            <!-- Skill -->
                            <div class="form-group">
                                <label for="predikat">Predikat</label>
                                <input 
                                    type="text" 
                                    name="predikat" 
                                    id="predikat" 
                                    placeholder="Predikat"
                                    class="form-control @error('predikat') is-invalid @enderror"
                                    value="{{ old('predikat', isset($nilai) ? $nilai->predikat : '') }}">
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label for="kompetensi_unggulan">Kompetensi Unggulan</label>
                                <input 
                                    type="text" 
                                    name="kompetensi_unggulan" 
                                    id="kompetensi_unggulan" 
                                    placeholder="Kompetensi Unggulan"
                                    class="form-control @error('kompetensi_unggulan') is-invalid @enderror"
                                    value="{{ old('kompetensi_unggulan', isset($nilai) ? $nilai->kompetensi_unggulan : '') }}">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">{{ isset($nilai) ? 'Update' : 'Submit' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const fileInput = document.getElementById('file_nilai');

        form.addEventListener('submit', function (e) {
            // Cek apakah file belum diupload
            if (!fileInput.files.length) {
                e.preventDefault(); // Menghentikan pengiriman form
                alert('Silakan upload file sebelum mengirimkan formulir!');
            }
        });
    });
</script>
@endpush

