@extends('layouts.app')

@section('title', 'Upload Tugas')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('library/codemirror/theme/duotone-dark.css') }}">
    <style>
        .file-preview {
            margin-top: 1rem;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .file-content {
            white-space: pre-wrap; /* Preserve whitespace for text files */
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h2 class="section-title">Sistem e-learning Komputer 77</h2>
            </div>

            <div class="section-body">
                <!-- Menampilkan Alert Success -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <!-- Menampilkan Alert Error -->
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('kumpul.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="card-header">
                                <h3>Upload Tugas</h3>
                            </div>

                            <div class="form-group">
                                <label for="kelas">Judul Tugas</label>
                                <input id="judul_tugas" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="judul_tugas" autofocus required>
                                <div class="invalid-feedback">
                                Please fill in your Judul Tugas.
                                </div>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="file">Upload File Tugas Anda:</label>
                                <input type="file" id="file" name="file" class="form-control"
                                    accept=".pdf,.doc,.docx,.txt,.xls,.xlsx,.ppt,.pptx" required>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="file-preview" id="file-preview" style="display: none;">
                                <strong>Preview File:</strong>
                                <div id="preview-content"></div>
                            </div>

                            <div class="text-md-right">
                                <div class="float-lg-left mb-lg-0 mb-3">
                                    <button type="submit" class="btn btn-primary btn-icon icon-left">
                                        <i class="fas fa-upload"></i> Upload Tugas
                                    </button>
                                    <a href="{{ route('kumpul.create') }}" class="btn btn-danger btn-icon icon-left">
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
@endsection

@push('scripts')
    <script>
        document.getElementById('file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('file-preview');
            const previewContent = document.getElementById('preview-content');

            if (file) {
                // Show the preview container
                previewContainer.style.display = 'block';

                // Clear previous content
                previewContent.innerHTML = '';

                // Create a file type specific preview
                const fileType = file.type;
                const fileReader = new FileReader();

                fileReader.onload = function(e) {
                    const content = e.target.result;

                    if (fileType.includes('image/')) {
                        const img = document.createElement('img');
                        img.src = content;
                        img.style.width = '100%';
                        previewContent.appendChild(img);
                    } else if (fileType.includes('pdf')) {
                        const pdfEmbed = document.createElement('embed');
                        pdfEmbed.src = content;
                        pdfEmbed.type = 'application/pdf';
                        pdfEmbed.style.width = '100%';
                        pdfEmbed.style.height = '400px';
                        previewContent.appendChild(pdfEmbed);
                    } else {
                        previewContent.innerHTML = `<p>File: ${file.name}</p>`;
                    }
                };

                fileReader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        });
    </script>
@endpush
