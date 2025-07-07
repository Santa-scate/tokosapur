<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1, h2 { text-align: center; }
    </style>
</head>
<body>
    <h1>Laporan Penjualan</h1>
    <h2>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</h2>
    <p><strong>Total Pendapatan: Rp {{ number_format($totalRevenue) }}</strong></p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $sale->user->name }}</td>
                <td>Rp {{ number_format($sale->total_price) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

