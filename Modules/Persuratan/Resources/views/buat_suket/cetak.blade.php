<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Surat Keterangan</title>
    <style>
        body {
            font-family: 'Bookman Old Style', serif;
            font-size: 11pt;
            margin: 40px;
        }

        table {
            width: 100%;
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
</head>

<body>
    <table>
        <tr>
            <td width="12%">
                <img src="{{ asset('assets/images/LogoKabupatenBrebes.png') }}" style="width: 100%;">
            </td>
            <td>
                <p style="font-size: 14pt; text-align: center; font-weight: bold;">
                    PEMERINTAH KABUPATEN BREBES<br>
                    DINAS KESEHATAN DAERAH<br>
                    UNIT ORGANISASI BERSIFAT KHUSUS RSUD BREBES
                </p>
                <p style="font-size: 7pt; text-align: center;">
                    Jalan Jenderal Sudirman Nomor 181 Brebes Telepon (0283) 671431 Faksimile (0283) 671095
                </p>
                <p style="font-size: 7pt; text-align: center;">
                    Pos-el rsudbrebes@gmail.com
                </p>
            </td>
        </tr>
    </table>

    <hr style="border: none; border-top: 4px solid black; margin: 0;">
    <br>

    <p style="text-align:center; font-weight:bold;">
        {{ $surat->nama_suket }}<br>
        Nomor: {{ $surat->kode }}/{{ $surat->nomor }}/{{ $surat->bulan }}/{{ $surat->tahun }}
    </p>

    <br>
    <p>Yang bertanda tangan di bawah ini:</p>
    <table>
        <tr>
            <td width="30%">Nama</td>
            <td>:</td>
            <td>Dr. dr. Rasipin, M.Kes, MARS</td>
        </tr>
        <tr>
            <td>NIP</td>
            <td>:</td>
            <td>19681125 200212 1 002</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>Direktur</td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td>:</td>
            <td>RSUD Brebes</td>
        </tr>
    </table>

    <br>
    <p>Dengan ini menerangkan bahwa Saudara/i:</p>
    <table>
        <tr>
            <td width="30%">Nama</td>
            <td>:</td>
            <td>
                {{ ($surat->gelar_depan ? $surat->gelar_depan . '. ' : '') . Str::title(strtolower($surat->nama)) . ($surat->gelar_belakang ? ', ' . $surat->gelar_belakang : '') }}
            </td>
        </tr>
        <tr>
            <td>NIP/NRP</td>
            <td>:</td>
            <td>{{ $surat->nip_nipppk_nrpk_nrpblud }}</td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>:</td>
            <td>{{ Str::title(strtolower($surat->tempat_lahir)) }},
                {{ \Carbon\Carbon::parse($surat->tanggal_lahir)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Pendidikan</td>
            <td>:</td>
            <td>{{ $pendidikan->nama ?? '-' }} {{ $pendidikan->jurusan ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $jabatan->nama ?? '-' }}</td>
        </tr>
    </table>

    <br>
    <p style="text-align: justify;">{!! nl2br(e($isiSurat ?? 'Isi surat belum tersedia.')) !!}</p>

    <br>
    <p style="text-align: justify;">
        Demikian surat keterangan ini dibuat dengan sesungguhnya dan sebenar-benarnya untuk dapat digunakan sebagaimana
        mestinya.
    </p>
    <br>
    <table style="text-align: center;">
        <tr>
            <td width="60%"></td>
            <td>Brebes, {{ \Carbon\Carbon::parse($surat->tanggal_terbit)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Direktur RSUD Brebes</td>
        </tr>
        <tr>
            <td colspan="2"><br><br><br></td>
        </tr>
        <tr>
            <td></td>
            <td>Dr. dr. Rasipin, M.Kes, MARS<br>NIP. 19681125 200212 1 002</td>
        </tr>
    </table>

    <div style="page-break-after: always;"></div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

    @if (session('from_setujui') || request('redirect'))
        <script>
            setTimeout(() => {
                window.location.href = document.referrer || "{{ url()->previous() }}";
            }, 1000);
        </script>
    @endif
</body>

</html>
