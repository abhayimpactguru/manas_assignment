<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        
        $data = [
            'totalCustomers' => Customer::count(),
            'totalOrders' => Order::count(),
            'totalRevenue' => Order::where('status', 'completed')->sum('amount'),
            'recentCustomers' => Customer::latest()->take(5)->get(),
            'recentOrders' => Order::with('customer')->latest()->take(5)->get(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'completedOrders' => Order::where('status', 'completed')->count(),
            'cancelledOrders' => Order::where('status', 'cancelled')->count(),
        ];

        if ($user->isAdmin()) {
            $data['totalUsers'] = User::count();
            $data['adminCount'] = User::where('role', 'admin')->count();
            $data['staffCount'] = User::where('role', 'staff')->count();
        }

        return view('dashboard', $data);
    }
}
