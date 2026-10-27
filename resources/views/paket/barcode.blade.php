<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Barcode</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
        }

        td {
            width: 33.33%;
            text-align: center;
            vertical-align: top;
        }

        .box {
            display: inline-block;
            border: 1px solid #333;
            padding: 10px;
            min-width: 180px;
        }

        .kode {
            margin-top: 5px;
            font-size: 11px;
        }
    </style>
</head>

<body>

    <table>
        <tr>

            @foreach($datapaket as $paket)

            <td>
                <div class="box">

                    {!! DNS1D::getBarcodeHTML($paket->kode_paket, 'C39', 1, 30) !!}

                    <div class="kode">
                        {{ $paket->kode_paket }}
                    </div>

                </div>

            </td>

            @if($no % 3 == 0)
        </tr>
        <tr>
            @endif

            @php $no++; @endphp

            @endforeach

        </tr>
    </table>

</body>

</html>