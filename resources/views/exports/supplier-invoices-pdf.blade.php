<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Export' }}</title>
    @php
        $paperSize = strtoupper($paper ?? 'A4');
        $orientationInput = strtolower($orientation ?? '');
        $orientation = in_array($orientationInput, ['portrait', 'landscape']) ? $orientationInput : 'landscape';
    @endphp
    <style>
        @page { size: {{ $paperSize }} {{ $orientation }}; margin: 10mm 8mm; }
        * { box-sizing: border-box; }
        html, body { width: 100%; height: 100%; }
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 11px; color: #111827; margin: 0; }
        h1 { font-size: 16px; margin: 0 0 6px; }
        .meta { font-size: 10px; color: #6b7280; margin-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid #e5e7eb; padding: 4px 6px; text-align: left; vertical-align: top; word-wrap: break-word; overflow-wrap: anywhere; }
        th { background: #f3f4f6; font-weight: 600; }
        tr:nth-child(even) td { background: #fafafa; }
        .right { text-align: right; }
        .summary-row td { font-weight: 600; background: #f3f4f6; }
    </style>
</head>
<body>
    <h1>{{ $title ?? 'Export' }}</h1>
    <div class="meta">Date Range: {{ $dateRange ?? 'All Dates' }}</div>
    <div class="meta">Generated at: {{ isset($generatedAt) ? \Illuminate\Support\Carbon::parse($generatedAt)->format('Y-m-d H:i') : now()->format('Y-m-d H:i') }}</div>

    <table>
        <thead>
            <tr>
                @foreach ($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td>{{ is_scalar($cell) ? (string) $cell : json_encode($cell) }}</td>
                    @endforeach
                </tr>
            @endforeach
            @if (!empty($summaryRow))
                <tr class="summary-row">
                    @foreach ($summaryRow as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
