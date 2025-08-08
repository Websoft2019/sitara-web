<!DOCTYPE html>
<html>
<head>
    <title>Duplicate Emails Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #dddddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Duplicate Emails Report</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($duplicateEntries as $entry)
                <tr>
                    <td>{{ $entry['id'] }}</td>
                    <td>{{ $entry['email'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
