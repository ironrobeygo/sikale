<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();

        return view('sales.customers.index', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Customer::class],
            'phone' => ['required', 'numeric'],
            'tax_number' => ['required', 'string'],
        ]);

        $customer = Customer::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'tax_number' => $request->tax_number,
            'address'   => $request->address,
            'city'      => $request->city,
            'postal'    => $request->postal
        ]);

        return redirect('/sales/customers');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        dd($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('sales.customers.edit', ['customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $customer->name     = $request->name;
        $customer->email    = $request->email;
        $customer->phone    = $request->phone;
        $customer->tax_number = $request->tax_number;
        $customer->address  = $request->address;
        $customer->city     = $request->city;
        $customer->postal   = $request->postal;

        $customer->save();

        return redirect('/sales/customers');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        dd('Echo 1');
    }
}
