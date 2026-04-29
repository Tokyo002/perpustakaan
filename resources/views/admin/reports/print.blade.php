<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body { padding: 20px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
<div class="d-flex justify-content-between align-items-center mb-3 no-print">
    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
    <button onclick="window.print()" class="btn btn-primary btn-sm">Cetak</button>
</div>

<h3 class="mb-3">{{ $title }}</h3>
<div class="table-responsive">
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            @foreach(array_keys(($rows->first() ?? ['data' => '-'])) as $header)
                <th>{{ ucwords(str_replace('_', ' ', $header)) }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $row)
            <tr>
                @foreach($row as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
