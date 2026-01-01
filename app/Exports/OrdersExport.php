<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    protected ?string $status;

    public function __construct(?string $status = null)
    {
        $this->status = $status;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Order::with('customer');
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Order Number',
            'Customer',
            'Amount',
            'Status',
            'Order Date',
            'Created At',
        ];
    }

    /**
     * @param Order $order
     * @return array
     */
    public function map($order): array
    {
        return [
            $order->id,
            $order->order_number,
            $order->customer->name,
            $order->amount,
            ucfirst($order->status),
            $order->order_date->format('Y-m-d'),
            $order->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
