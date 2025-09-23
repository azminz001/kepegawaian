<!DOCTYPE html>
<html>

<head>
    <title>Cetak Kehadiran</title>
    <style>
        body {
            font-family: 'Bookman Old Style', serif;
            font-size: 11pt;
            margin: 40px;
        }

        /* Tabel default: ada garis */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1cm;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        /* Tabel tanpa garis (misalnya untuk data rapat) */
        table.no-border td,
        table.no-border {
            border: none;
        }

        table.no-border td {
            padding: 4px;
        }

        p {
            margin: 4px 0;
        }

        @page {
            size: 21cm 33cm;
            margin: 2cm;
        }

        .header {
            text-align: center;
            margin-bottom: 1cm;
        }

        .footer {
            margin-top: 2cm;
            font-size: 10pt;
        }
    </style>

    <script>
        window.onload = function() {
            window.print();
            setTimeout(() => window.close(), 1000);
        };
    </script>
</head>

<body>
    <h3 class="text-center" style="text-align: center;">DAFTAR KEHADIRAN</h3>

    <table class="no-border">
        <tr>
            <td><strong>Nama Agenda</strong></td>
            <td width="3%">
                <center>:</center>
            </td>
            <td>{{ strtoupper($rapat->nama_rapat) }}</td>
        </tr>
        <tr>
            <td><strong>Hari, Tanggal</strong></td>
            <td>
                <center>:</center>
            </td>
            <td>{{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('l, d F Y') }}</td>
        </tr>
        <tr>
            <td><strong>Pukul</strong></td>
            <td>
                <center>:</center>
            </td>
            <td>{{ \Carbon\Carbon::parse($rapat->jam_mulai)->format('H:i') }} WIB - {{ \Carbon\Carbon::parse($rapat->jam_selesai)->format('H:i') }} WIB</td>
        </tr>
        <tr>
            <td><strong>Tempat</strong></td>
            <td>
                <center>:</center>
            </td>
            <td>{{ $rapat->nama }}</td>
        </tr>
    </table>

    <!-- Tabel kedua: DENGAN GARIS -->
    <table>
        <thead>
            <tr>
                <th width="3%"><center>NO</center></th>
                <th><center>NAMA LENGKAP</center></th>
                <th><center>NIP / NRP</center></th>
                <th><center>INSTANSI</center></th>
                <th width="15%"><center>TTD</center></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kehadirans as $i => $peserta)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $peserta->nama_peserta }}</td>
                <td>{{ $peserta->nip_nrp }}</td>
                <td>{{ $peserta->instansi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <table class="no-border">
        <tr>
            <td width="60%"></td>
            <td><center>Brebes, {{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('d F Y') }}</center></td>
        </tr>
        <tr>
            <td></td>
            <td><center>Direktur RSUD Brebes</center></td>
        </tr>
        <tr>
            <td colspan="2"><br><br><br></td>
        </tr>
        <tr>
            <td></td>
            <td><center>Dr. dr. Rasipin, M.Kes, MARS<br>NIP. 19681125 200212 1 002</center></td>
        </tr>
    </table>
</body>

</html>