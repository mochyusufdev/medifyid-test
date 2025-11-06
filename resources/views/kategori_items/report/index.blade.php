<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Kategori {{ $kategori->nama }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table,
        th,
        td {
            border: 1px solid #444;
        }

        th,
        td {
            padding: 6px;
            text-align: left;
        }

        h2 {
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 0;
            right: 0;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>
    <h2>Laporan Kategori</h2>
    <p><strong>Nama Kategori:</strong> {{ $kategori->nama }}</p>
    <p><strong>Kode Kategori:</strong> {{ $kategori->kode }}</p>

    <h4>Daftar Item</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Item</th>
                <th>Jenis</th>
                <th>Harga Beli</th>
                <th>Laba (%)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategori->masterItems as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td>{{ $item->laba }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Tidak ada item</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dicetak pada: {{ $waktuCetak }}</div>
</body>

</html>
