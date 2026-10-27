<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pendapatan</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h3, h4 {
            text-align: center;
            margin: 0;
        }

        h4 {
            margin-top: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        td:nth-child(1) {
            text-align: center;
            width: 5%;
        }

        td:nth-child(3) {
            text-align: right;
        }
    </style>
</head>
<body>

    <h3>Laporan Pendapatan</h3>

    <h4>
        Tanggal {{ tanggal_indonesia($awal, false) }}
        s/d
        Tanggal {{ tanggal_indonesia($akhir, false) }}
    </h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pendapatan</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row['DT_RowIndex'] }}</td>
                    <td>{{ $row['tanggal'] }}</td>
                    <td>{{ $row['pendapatan'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>