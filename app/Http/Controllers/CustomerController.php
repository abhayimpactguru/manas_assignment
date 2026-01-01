<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Exports\CustomersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->withCount('orders')
                          ->latest()
                          ->paginate(10)
                          ->withQueryString();

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('customers', 'public');
        }

        Customer::create($data);

        return redirect()->route('customers.index')
                        ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->load('orders');
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $data = $request->validated();

        if ($request->hasFile('profile_image')) {
            if ($customer->profile_image) {
                Storage::disk('public')->delete($customer->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('customers', 'public');
        }

        $customer->update($data);

        return redirect()->route('customers.index')
                        ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        if ($customer->profile_image) {
            Storage::disk('public')->delete($customer->profile_image);
        }

        $customer->delete();

        return redirect()->route('customers.index')
                        ->with('success', 'Customer deleted successfully.');
    }

    /**
     * Export customers to CSV.
     */
    public function exportCsv()
    {
        return Excel::download(new CustomersExport, 'customers.csv');
    }

    /**
     * Export customers to PDF.
     */
    public function exportPdf()
    {
        $customers = Customer::all();
        $pdf = Pdf::loadView('customers.pdf', compact('customers'));
        return $pdf->download('customers.pdf');
    }
}
