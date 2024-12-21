<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat Nilai</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .certificate-container {
            border: 5px double #000;
            padding: 40px;
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            position: relative;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .certificate-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .certificate-header img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }
        .certificate-header h1 {
            font-size: 36px;
            color: #2c3e50;
            margin: 0;
        }
        .certificate-header p {
            font-size: 18px;
            color: #7f8c8d;
        }
        .certificate-content {
            text-align: center;
        }
        .certificate-content h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .certificate-content p {
            font-size: 18px;
            margin: 5px 0;
        }
        .certificate-table {
            margin: 30px auto;
            width: 80%;
            text-align: left;
            border-collapse: collapse;
        }
        .certificate-table td {
            padding: 10px;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
        }
        .certificate-footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            font-style: italic;
            color: #7f8c8d;
        }
        .stamp {
            position: absolute;
            bottom: 20px;
            right: 20px;
            padding: 10px 30px;
            font-size: 22px;
            font-weight: bold;
            color: #2980b9; /* Biru */
            transform: rotate(-15deg);
            border: 3px solid #2980b9;
            text-transform: uppercase;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Header with logo -->
        <div class="certificate-header">
            <img src="{{ public_path('img/komputer 77.jpg') }}" alt="Logo Bimbel">
            <h1>SERTIFIKAT</h1>
            <p>Pengakuan resmi atas pencapaian akademik</p>
        </div>

        <!-- Main content -->
        <div class="certificate-content">
            <p>Dengan ini, kami menyatakan bahwa</p>
            <h2>{{ $nilai->name }}</h2>
            <p>Telah mengikuti Kelas Bimbel Computer 77 dengan nilai sebagai berikut:</p>

            <!-- Score table -->
            <table class="certificate-table">
                <tr>
                    <td>Nilai Tugas:</td>
                    <td>{{ $nilai->nilai_tugas }}</td>
                </tr>
                <tr>
                    <td>Nilai Ujian:</td>
                    <td>{{ $nilai->nilai_ujian }}</td>
                </tr>
                <tr>
                    <td>Predikat:</td>
                    <td>{{ $nilai->predikat }}</td>
                </tr>
                <tr>
                    <td>Kompetensi Unggulan:</td>
                    <td>{{ $nilai->kompetensi_unggulan }}</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <p class="certificate-footer">Terima kasih telah mengikuti Kelas Bimbel Computer 77. Kami mendoakan kesuksesan Anda dalam perjalanan akademik dan karir di masa depan.</p>

        <!-- Stamp -->
        <div class="stamp">
            VERIFIED
        </div>

    </div>
</body>
</html>
