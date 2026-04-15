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
            top: 3mm;
            left: 4mm;
            width: 202mm;
            overflow: hidden;
        }

        table {
            border-collapse: separate;
            border-spacing: 3mm 1.5mm;
            table-layout: fixed;
            width: 208mm;
            margin-left: -2.5mm;
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
            /* border: 0.5px solid black; */
        }

        .container {
            display: flex;
            justify-content: center;
        }

        .container h3 {
            display: flex;
            align-items: center;
            white-space: normal;
            word-break: break-word;
            overflow: hidden;
            font-weight: bold;
            font-size: 8px;
            margin: 0mm 3mm 0mm 3mm;
        }
        .container p {
            font-size: 8px;
        }
    </style>
</head>
<body>
    <div class="sheet">
        <table>
            @php 
            require '../vendor/autoload.php';
            $barangIndex = 0; 
            $renderer = new Picqer\Barcode\Renderers\PngRenderer();
            @endphp
            @for ($row = 1; $row <= 8; $row++)
                <tr>
                    @for ($col = 1; $col <= 5; $col++)
                        <td>
                            <div class="container">
                                @if($row >= $startRow && ($row > $startRow || $col >= $startCol) && isset($barang[$barangIndex]))
                                    <h3>{{ $barang[$barangIndex]->nama }}</h3>
                                    <p>Rp {{ number_format($barang[$barangIndex]->harga) }}</p>
                                    @php 
                                    $barcode = (new Picqer\Barcode\Types\TypeCode128())->getBarcode($barang[$barangIndex]->id_barang);
                                    $barcodeImage = base64_encode($renderer->render($barcode, 80, 10));
                                    @endphp
                                    <div>
                                        <div>
                                            <img src="data:image/png;base64,{{ $barcodeImage }}" height:auto;">
                                        </div>
                                    </div>
                                    <div>
                                        <div>
                                            {{ $barang[$barangIndex]->id_barang }}
                                        </div>
                                    </div>
                                    @php $barangIndex++; @endphp
                                @endif
                            </div>
                        </td>
                    @endfor
                </tr>
            @endfor
        </table>
    </div>
</body>
</html>