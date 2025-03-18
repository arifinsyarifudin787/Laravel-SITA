<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Bimbingan Skripsi</title>
    <style>
        body { font-family: Calibri, Arial, Helvetica; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td { padding: 3px;}
        th { text-align: center; font-weight: bold}
        th, .border td { border: 1px solid black;}
        .border-x-0 {
            border-left: white;
            border-right: white;
        }
        image {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <table class="border" style="text-align: left; font-size: 16px">
        <tr>
            <td rowspan="4">
                <img src="{{ asset('assets/img/logo_uin.png') }}" alt="" height="90px">
            </td>
            <td rowspan="4" style="font-size: 28px; text-align:center;"><b>FORM (FR)<b></td>
            <td>No. Dok.</td>
            <td class="border-x-0">:</td>
            <td>FST-TU-AKM-FR-F.12</td>
        </tr>
        <tr>
            <td>Tgl. Terbit</td>
            <td class="border-x-0">:</td>
            <td>1 September 2014</td>
        </tr>
        <tr>
            <td>No. Revisi</td>
            <td class="border-x-0">:</td>
            <td>00</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td class="border-x-0">:</td>
            <td>1/1</td>
        </tr>
        <tr>
            <td colspan="5" style="font-size: 24px; text-align:center;"><b>LEMBAR BIMBINGAN SKRIPSI</b></td>
        </tr>
    </table>
    <table style="width: 92%; margin-left: auto; margin-right: auto; font-size: 18px; margin-bottom: 20px">
        <tr>
            <td>NIM</td>
            <td>:</td>
            <td>{{ $tugas_akhir->nim }}&emsp;&emsp;&emsp;&emsp;&emsp;</td>
            <td>Tanggal SK</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>NAMA</td>
            <td>:</td>
            <td>{{ $mahasiswa->name }}</td>
            <td>Pembimbing I</td>
            <td>:</td>
            <td>{{ $pembimbing1 }}</td>
        </tr>
        <tr>
            <td>Jurusan&emsp;&emsp;&emsp;</td>
            <td>:</td>
            <td>Teknik Informatika</td>
            <td>Pembimbing II</td>
            <td>:</td>
            <td>{{ $pembimbing2 }}</td>
        </tr>   
        <tr style="vertical-align: top">
            <td>Judul</td>
            <td>:</td>
            <td colspan="4">{{ $tugas_akhir->judul }}</td>
        </tr>
    </table>
    <table class="border" style="font-size: 18px;">
        <tr>
            <th style="width: 60px">Perte- muan- ke</th>
            <th style="width: 110px">Tanggal Bimbingan</th>
            <th style="min-width: 300px">Materi Bimbingan</th>
            <th style="min-width: 300px">Saran/ Perbaikan</th>
            <th style="width: 120px">Paraf Pembimbing</th>
        </tr>
        @foreach ($bimbingan as $b)
        <tr style="vertical-align: top">
            <td style="text-align: center; vertical-align: middle">{{ $loop->iteration }}</td>
            <td>{{ $b->tanggal() }}</td>
            <td>{{ $b->materi }}</td>
            <td>
                {{ optional($b->persetujuanPembimbing1)->saran }}
                <br>
                {{ optional($b->persetujuanPembimbing2)->saran }}
            </td>
            <td></td>
        </tr>
        @endforeach
    </table>
    <table style="margin-top: auto; margin-left: 10px; width: 90%; font-size: 18px;">
        <tr>
            <td>
                Mengetahui,<br>
                Ketua Jurusan<br><br><br><br>
                <b>
                    Dr. Dian Sa'adillah Maylawati, M.T.&emsp;&emsp;&emsp;
                </b><br>
                NIP. 198905262019032023
            </td>
            <td>
                Bandung, {{ now()->translatedFormat('j F Y') }}<br>
                Mahasiswa<br><br><br><br>
                <b>
                    {{ $mahasiswa->name }}
                </b><br>
                NIM. {{ $mahasiswa->username }}
            </td>
        </tr>
    </table>
</body>
</html>
