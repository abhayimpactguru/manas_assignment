<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customers Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; color: #4F46E5; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4F46E5; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <h1>Customers Report</h1>
    <p>Generated on: {{ now()->format('F d, Y H:i:s') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone ?? '-' }}</td>
                    <td>{{ $customer->address ?? '-' }}</td>
                    <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>ImpactGuru Mini CRM - Total Customers: {{ $customers->count() }}</p>
    </div>
</body>
</html>
