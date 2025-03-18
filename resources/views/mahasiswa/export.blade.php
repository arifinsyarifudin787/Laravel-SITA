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
        image {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <table class="border" style="text-align: left; font-size: 12px">
        <tr>
            <td rowspan="4" style="padding:0">
                @php
                    $path = public_path('assets/img/logo_uin.png');
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);    
                @endphp
                <img src="{{ $base64 }}" alt="" height="75px" style="margin-left: 5px">
            </td>
            <td rowspan="4" style="font-size: 18px; text-align:center;"><b>FORM (FR)<b></td>
            <td>No. Dok.</td>
            <td>:</td>
            <td>FST-TU-AKM-FR-F.12</td>
        </tr>
        <tr>
            <td>Tgl. Terbit</td>
            <td>:</td>
            <td>1 September 2014</td>
        </tr>
        <tr>
            <td>No. Revisi</td>
            <td>:</td>
            <td>00</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td>:</td>
            <td>1/1</td>
        </tr>
        <tr>
            <td colspan="5" style="font-size: 16px; text-align:center;"><b>LEMBAR BIMBINGAN SKRIPSI</b></td>
        </tr>
    </table>
    <table style="width: 92%; margin-left: auto; margin-right: auto; font-size: 13px; margin-bottom: 40px">
        <tr>
            <td>NIM</td>
            <td>:</td>
            <td style="white-space: pre;">{{ $tugas_akhir->nim }}                                    </td>
            <td style="max-width: 110">Tanggal SK</td>
            <td>:</td>
            <td style="white-space: pre;">                           </td>
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
            <td style="white-space: pre;">Jurusan            </td>
            <td>:</td>
            <td>Teknik Informatika</td>
            <td>Pembimbing II</td>
            <td>:</td>
            <td>{{$pembimbing2 }}</td>
        </tr>   
        <tr style="vertical-align: top">
            <td>Judul</td>
            <td>:</td>
            <td colspan="4">{{ $tugas_akhir->judul }}</td>
        </tr>
    </table>
    <table class="border" style="font-size: 13px;">
        <tr>
            <th style="width: 50px">Perte- muan- ke</th>
            <th style="width: 90px">Tanggal Bimbingan</th>
            <th style="min-width: 200px">Materi Bimbingan</th>
            <th style="min-width: 200px">Saran/ Perbaikan</th>
            <th style="width: 100px">Paraf Pembimbing</th>
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
        @for ($i = $bimbingan->count(); $i < 10; $i++)
            <tr>
                <td style="text-align: center; vertical-align: middle">{{ $i+1 }}</td>
                <td style="white-space: pre;"> <br> </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endfor
    </table>
    <table style="margin-top: 20px; margin-left: 10px; width: 90%; font-size: 13px;">
        <tr>
            <td>
                Mengetahui,<br>
                Ketua Jurusan<br><br><br><br><br><br>
                <b style="white-space: pre;">Dr. Dian Sa'adillah Maylawati, M.T.              </b><br>
                NIP. 198905262019032023
            </td>
            <td>
                Bandung, {{ now()->translatedFormat('j F Y') }}<br>
                Mahasiswa<br><br><br><br><br><br>
                <b>
                    {{ $mahasiswa->name }}
                </b><br>
                NIM. {{ $mahasiswa->username }}
            </td>
        </tr>
    </table>
</body>
</html>
