<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 100px;
        }
        .header h3 {
            margin: 10px 0 5px;
        }
        .details {
            margin-top: 20px;
            line-height: 1.6;
        }
        .details p {
            margin: 5px 0;
        }
        .validated {
            text-align: center;
            margin-top: 30px;
            padding: 10px;
            background: #e6ffe6;
            border: 1px solid #4caf50;
            border-radius: 5px;
            color: #4caf50;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('img/komputer 77.jpg') }}" alt="Logo Bimbel">
            <h3>Struk Pembayaran</h3>
            <p>Bimbel Computer77</p>
        </div>

        <div class="details">
            <p><strong>Nama:</strong> {{ $pembayaran->name }}</p>
            <p><strong>Jenis Paket:</strong> {{ $pembayaran->jenis_paket }}</p>
            <p><strong>Harga:</strong> Rp. {{ number_format($pembayaran->harga, 0, ',', '.') }}</p>
            <p><strong>Tanggal Pembayaran:</strong> {{ $pembayaran->created_at->format('d M Y H:i') }}</p>
        </div>

        <div class="validated">
            Struk ini telah divalidasi oleh Admin.
        </div>
    </div>
</body>
</html>
