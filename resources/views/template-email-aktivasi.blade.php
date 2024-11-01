<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Aktivasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #222644;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .content table, .content th, .content td {
            border: 1px solid #dddddd;
            padding: 8px;
        }
        .content th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .footer {
            background-color: #222644;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Kode Aktivasi</h1>
        </div>
        <div class="content">
            <p>Halo Admin Utama,</p>
            <p>Ada yang mengajukan aktivasi, berikut adalah kodenya :</p>
            <table>
                <tr>
                    <th>PERMINTAAN DARI</th>
                    <td>{{ $nama_teknisi }}</td>
                </tr>
                <tr>
                    <th>KODE</th>
                    <td>{{ $kode_aktivasi }}</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p>&copy; 2024 Complaint App. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
