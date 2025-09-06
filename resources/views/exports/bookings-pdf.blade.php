<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Export' }}</title>
    <style>
        /* Professional table-only styling */
        table { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 11px; table-layout: fixed; }
        thead { display: table-header-group; }
        thead th { background: #f1f5f9; color: #1e293b; font-weight: 600; padding: 6px 8px; border: 1px solid #d6dde4; font-size: 10.5px; text-align: left; }
        thead th:first-child { border-top-left-radius: 4px; }
        thead th:last-child { border-top-right-radius: 4px; }
        tbody td { background: #ffffff; padding: 5px 8px; border: 1px solid #e2e8f0; vertical-align: top; color: #334155; line-height: 1.35; }
        tbody tr:nth-child(even) td { background: #f8fafc; }
        tbody tr:hover td { background: #f1f5f9; }
        tbody tr:last-child td:first-child { border-bottom-left-radius: 4px; }
        tbody tr:last-child td:last-child { border-bottom-right-radius: 4px; }
        td.right, th.right { text-align: right; }
        td.center, th.center { text-align: center; }
        td.nowrap, th.nowrap { white-space: nowrap; }
        td.wrap, th.wrap { white-space: normal; word-break: break-word; }
        /* Subtle column separators */
        thead th + th, tbody td + td { border-left-color: #dbe2e8; }
        /* Prevent header row from splitting */
        thead tr { page-break-inside: avoid; }
    </style>
</head>
<body>
    <h1>{{ $title ?? 'Export' }}</h1>
    <div class="meta-group">
        <div class="meta">Generated: {{ isset($generatedAt) ? \Illuminate\Support\Carbon::parse($generatedAt)->format('Y-m-d H:i') : now()->format('Y-m-d H:i') }}</div>
        @isset($dateRange)
            <div class="meta">Date Range: {{ $dateRange }}</div>
        @endisset
    </div>

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
                        @php($value = is_scalar($cell) ? (string) $cell : json_encode($cell))
                        @php($isNumeric = is_numeric(str_replace([',',' '],'',$value)))
                        <td class="{{ $isNumeric ? 'right' : '' }}">{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
