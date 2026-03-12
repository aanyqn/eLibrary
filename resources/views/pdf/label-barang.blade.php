<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: 210mm 165mm;
            margin: 0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: sans-serif;
            width: 210mm;
            height: 165mm;
            overflow: hidden;
        }

        .sheet {
            position: absolute;
            top: 4mm;
            left: 4mm;
            width: 202mm;
            overflow: hidden;
        }

        table {
            border-collapse: separate;
            border-spacing: 3mm 1.5mm;
            table-layout: fixed;
            width: 208mm;
            margin-left: -3mm;
            margin-top: -1mm;
        }

        td {
            width: 38mm;
            height: 18mm;
            vertical-align: middle;
            text-align: center;
            /* overflow: hidden; */
            font-size: 6.5px;
            line-height: 1.3;
            /* border: 1px solid black; */
        }

        td h2 {
            display: block;
            white-space: normal;
            word-break: break-word;
            overflow: hidden;
            font-weight: bold;
            font-size: 9px;
            margin: 0mm 3mm 0mm 3mm;
        }
        td p {
            font-size: 8px;
        }
    </style>
</head>
<body>
    <div class="sheet">
        <table>
            @php $barangIndex = 0; @endphp
            @for ($row = 1; $row <= 8; $row++)
                <tr>
                    @for ($col = 1; $col <= 5; $col++)
                        <td>
                            @if(
                                $row >= $startRow &&
                                ($row > $startRow || $col >= $startCol) &&
                                isset($barang[$barangIndex])
                            )
                                <h2>{{ $barang[$barangIndex]->nama }}</h2>
                                <p>Rp {{ number_format($barang[$barangIndex]->harga) }}</p>
                                {{ $barang[$barangIndex]->id_barang }}
                                @php $barangIndex++; @endphp
                            @endif
                        </td>
                    @endfor
                </tr>
            @endfor
        </table>
    </div>
</body>
</html>