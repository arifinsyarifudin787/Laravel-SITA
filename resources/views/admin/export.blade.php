<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Progress TA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        h2 {
            margin-bottom: 5px;
        }
        p {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>LAPORAN PROGRESS TUGAS AKHIR</h2>
    <p>Status: {{ $status }}</p>

    <table>
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Progress</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tugas_akhirs as $ta)
                <tr>
                    <td>{{ $ta->nim }}</td>
                    <td>{{ optional($ta->mahasiswa)->name ?? '-' }}</td>
                    <td>
                        @php
                            $totalBimbingan = 0;
                            foreach ($ta->mahasiswa->pembimbings as $p) {
                                $bimbingans = optional($ta->mahasiswa)->bimbingans->sum(
                                    fn($bimbingan) => $bimbingan->persetujuans->where('dosen_id', $p->id)->count()
                                );
                                $bimbingans = $bimbingans > 8 ? 8 : $bimbingans;
                                $totalBimbingan += $bimbingans;
                            }
                            $progress = $totalBimbingan / 16 * 100;
                        @endphp
                        {{ number_format($progress, 1) }}%
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
