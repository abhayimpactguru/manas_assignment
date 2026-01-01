<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Orders Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; color: #4F46E5; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4F46E5; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .status-pending { color: #D97706; font-weight: bold; }
        .status-completed { color: #059669; font-weight: bold; }
        .status-cancelled { color: #DC2626; font-weight: bold; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #666; }
        .summary { margin-top: 20px; padding: 10px; background: #f3f4f6; }
    </style>
</head>
<body>
    <h1>Orders Report</h1>
    <p>Generated on: {{ now()->format('F d, Y H:i:s') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>${{ number_format($order->amount, 2) }}</td>
                    <td class="status-{{ $order->status }}">{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->order_date->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="summary">
        <p><strong>Total Orders:</strong> {{ $orders->count() }}</p>
        <p><strong>Total Amount:</strong> ${{ number_format($orders->sum('amount'), 2) }}</p>
    </div>
    
    <div class="footer">
        <p>ImpactGuru Mini CRM</p>
    </div>
</body>
</html>
