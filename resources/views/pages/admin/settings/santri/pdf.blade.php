<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $record->nis }} {{ $record->nama }}</title>
</head>
<body>
    <div style="text-align: center">
        <h3><strong>Biodata Santri</strong></h3>
    </div>

    <hr/>
    <br/>

    <table>
        <tbody>
            <tr>
                <th style="text-align: left">NIS</th>
                <td>:</td>
                <td>{{ $record->nis }}</td>
            </tr>
            <tr>
                <th style="text-align: left">Nama</th>
                <td>:</td>
                <td>{{ $record->nama }}</td>
            </tr>
            <tr>
                <th style="text-align: left">Alamat</th>
                <td>:</td>
                <td>{{ $record->alamat }}</td>
            </tr>
            <tr>
                <th style="text-align: left">Asrama</th>
                <td>:</td>
                <td>{{ $record->asrama->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th style="text-align: left">Total Paket</th>
                <td>:</td>
                <td>{{ $record->total_paket }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>