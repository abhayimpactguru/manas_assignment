<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\User;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Exports\OrdersExport;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with('customer');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $orders = $query->latest()
                       ->paginate(10)
                       ->withQueryString();

        $customers = Customer::orderBy('name')->get();

        return view('orders.index', compact('orders', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        return view('orders.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $data['order_number'] = Order::generateOrderNumber();

        $order = Order::create($data);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewOrderNotification($order));
        }

        return redirect()->route('orders.index')
                        ->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('customer');
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $customers = Customer::orderBy('name')->get();
        return view('orders.edit', compact('order', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());

        return redirect()->route('orders.index')
                        ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $order->delete();

        return redirect()->route('orders.index')
                        ->with('success', 'Order deleted successfully.');
    }

    /**
     * Export orders to CSV.
     */
    public function exportCsv(Request $request)
    {
        return Excel::download(new OrdersExport($request->status), 'orders.csv');
    }

    /**
     * Export orders to PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Order::with('customer');
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $orders = $query->get();
        $pdf = Pdf::loadView('orders.pdf', compact('orders'));
        return $pdf->download('orders.pdf');
    }
}
