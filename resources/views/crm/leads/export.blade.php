<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid black;">
        <thead>
            <tr>
                <th colspan="9" style="text-align: center; font-weight: bold; font-size: 16px; border: 1px solid black; padding: 10px;">
                    Leads Report — From {{ $startDate }} To {{ $endDate }}
                </th>
            </tr>
            <tr>
                <th style="border: 1px solid black; background-color: #e3e3e3; font-weight: bold; text-align: center;">Date</th>
                <th style="border: 1px solid black; background-color: #e3e3e3; font-weight: bold; text-align: center;">Queries</th>
                <th style="border: 1px solid black; background-color: #e3e3e3; font-weight: bold; text-align: center;">New</th>
                <th style="border: 1px solid black; background-color: #e3e3e3; font-weight: bold; text-align: center;">Retrieved</th>
                <th style="border: 1px solid black; background-color: #e3e3e3; font-weight: bold; text-align: center;">Spam</th>
                <th style="border: 1px solid black; background-color: #e3e3e3; font-weight: bold; text-align: center;">Order Done</th>
                <th style="border: 1px solid black; background-color: #e3e3e3; font-weight: bold; text-align: center;">Replied</th>
                <th style="border: 1px solid black; background-color: #e3e3e3; font-weight: bold; text-align: center;">Read</th>
                <th style="border: 1px solid black; background-color: #e3e3e3; font-weight: bold; text-align: center;">Unread</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailyData as $date => $row)
            <tr>
                <td style="border: 1px solid black; text-align: center;">{{ $date }}</td>
                <td style="border: 1px solid black; text-align: center;">{{ $row['Queries'] }}</td>
                <td style="border: 1px solid black; text-align: center;">{{ $row['New'] }}</td>
                <td style="border: 1px solid black; text-align: center;">{{ $row['Retrine'] }}</td>
                <td style="border: 1px solid black; text-align: center;">{{ $row['Spam'] }}</td>
                <td style="border: 1px solid black; text-align: center;">{{ $row['Order Done'] }}</td>
                <td style="border: 1px solid black; text-align: center;">{{ $row['Replied'] }}</td>
                <td style="border: 1px solid black; text-align: center;">{{ $row['Read'] }}</td>
                <td style="border: 1px solid black; text-align: center;">{{ $row['Unread'] }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #d9edf7;">
                <th style="border: 1px solid black; font-weight: bold; text-align: right;">TOTAL</th>
                <th style="border: 1px solid black; font-weight: bold; text-align: center;">{{ $totals['Queries'] }}</th>
                <th style="border: 1px solid black; font-weight: bold; text-align: center;">{{ $totals['New'] }}</th>
                <th style="border: 1px solid black; font-weight: bold; text-align: center;">{{ $totals['Retrine'] }}</th>
                <th style="border: 1px solid black; font-weight: bold; text-align: center;">{{ $totals['Spam'] }}</th>
                <th style="border: 1px solid black; font-weight: bold; text-align: center;">{{ $totals['Order Done'] }}</th>
                <th style="border: 1px solid black; font-weight: bold; text-align: center;">{{ $totals['Replied'] }}</th>
                <th style="border: 1px solid black; font-weight: bold; text-align: center;">{{ $totals['Read'] }}</th>
                <th style="border: 1px solid black; font-weight: bold; text-align: center;">{{ $totals['Unread'] }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
