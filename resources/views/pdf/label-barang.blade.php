<style>
@page {
    size: 198mm 158mm;
    margin: 0;
}

body {
    margin: 0;
    padding: 0;
    font-family: sans-serif;
    font-size: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-left: 2mm;
    margin-top: 2mm;
}

td {
    width: 20%;
    height: 21mm;
    padding: 2mm;
    margin-right: 2mm;
    margin-bottom: 2mm;
    vertical-align: top;
}
</style>

<table>
@php
    $barangIndex = 0;
@endphp
@for ($row = 1; $row <= 8; $row++)
    @php $currentCol = 1; @endphp
    <tr>
        @for ($col = 1; $col <= 5; $col++)
            <td>
                @if(
                    $row >= $startRow &&
                    ($row > $startRow || $col >= $startCol) &&
                    isset($barang[$barangIndex])
                )
                    <strong>{{ $barang[$barangIndex]->nama }}</strong><br>
                    Rp {{ number_format($barang[$barangIndex]->harga) }}<br>
                    {{ $barang[$barangIndex]->id_barang }}
                    @php $barangIndex++; @endphp
                @endif
            </td>
            @php $currentCol++; @endphp
        @endfor
    </tr>
@endfor
</table>