<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Peminjaman</title>
    <style>
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 14px; 
            color: #000; 
            padding: 20px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 25px; 
            border-bottom: 3px solid #000; 
            padding-bottom: 10px; 
        }
        .header h2 { 
            margin: 0; 
            font-size: 22px; 
            text-transform: uppercase; 
            letter-spacing: 1px;
        }
        .header p { 
            margin: 5px 0 0; 
            color: #333; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
        }
        th, td { 
            border: 1px solid #000; 
            padding: 10px; 
            text-align: left; 
        }
        th { 
            background-color: #e0e0e0; 
            font-weight: bold; 
            text-align: center; 
        }
        .text-center { 
            text-align: center; 
        }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>Laporan Rekapitulasi Peminjaman Buku</h2>
        <h2>Perpustakaan Digital</h2>
        <p>Tanggal Cetak: {{ now()->format('d F Y H:i') }}</p>
        
        @if(request('tgl_awal') && request('tgl_akhir'))
            <p><strong>Periode:</strong> {{ request('tgl_awal') }} s/d {{ request('tgl_akhir') }}</p>
        @else
            <p><strong>Periode:</strong> Seluruh Waktu</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Peminjam</th>
                <th width="25%">Judul Buku</th>
                <th width="15%">Tanggal Pinjam</th>
                <th width="15%">Tenggat Waktu</th>
                <th width="20%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $p->user->nama_lengkap }}</td>
                <td>{{ $p->buku->judul }}</td>
                <td class="text-center">{{ $p->tanggal_peminjaman }}</td>
                <td class="text-center">{{ $p->tanggal_pengembalian }}</td>
                <td class="text-center">{{ $p->status_peminjaman }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4">Tidak ada data peminjaman pada periode yang dipilih.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 40px; width: 100%; text-align: right;">
        <p style="margin-bottom: 70px;">Mengetahui,<br>Kepala Perpustakaan</p>
        <p><strong>{{ Auth::user()->nama_lengkap }}</strong></p>
    </div>

    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; background-color: #ffc107; border: 1px solid #d39e00; font-weight: bold;">🖨️ Cetak Laporan</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer; background-color: #6c757d; color: white; border: none; margin-left: 10px;">Tutup Tab Ini</button>
    </div>

</body>
</html>
