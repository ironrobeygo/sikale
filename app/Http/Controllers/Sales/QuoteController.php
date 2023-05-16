<?php

namespace App\Http\Controllers\Sales;

use App\Http\Resources\CustomerResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LineItem;
use App\Models\Customer;
use App\Models\Quote;
use Carbon\Carbon;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = Quote::paginate(10);
        return view('sales.quotes.index', compact('quotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $customers = CustomerResource::collection(Customer::all());

        return view('sales.quotes.create', 
            compact('customers')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $quote = new Quote;
        $quote->customer_id = request()->customer_id;
        $quote->issue_date = Carbon::createFromFormat('m/d/Y', request()->issue_date)->toDateTimeString();
        $quote->expiry_date = Carbon::createFromFormat('m/d/Y', request()->expiry_date)->toDateTimeString();
        $quote->reference = request()->reference;
        $quote->status = 'draft';

        $quote->save();

        foreach(request()->line_items as $line_item){
            if(is_null($line_item['quantity'])) break;
            $lineItem = new LineItem;
            $lineItem->quote_id     = $quote->id;
            $lineItem->description  = $line_item['description'];
            $lineItem->quantity     = $line_item['quantity'];
            $lineItem->price        = $line_item['price'];
            $lineItem->discount     = $line_item['discount'];
            $lineItem->vat          = $line_item['vat'];
            $lineItem->amount       = $line_item['amount'];
            $lineItem->save();
        }

        return redirect('sales/quotes');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        return view('sales.quotes.edit', 
            compact('quote')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {

        $quote->issue_date = Carbon::createFromFormat('m/d/Y', request()->issue_date)->toDateTimeString();
        $quote->expiry_date = Carbon::createFromFormat('m/d/Y', request()->expiry_date)->toDateTimeString();
        $quote->reference = request()->reference;
        $quote->status = 'draft';

        $quote->save();

        foreach(request()->line_items as $line_item){
            $lineItem = LineItem::find($line_item['id']);
            $lineItem->quote_id     = $quote->id;
            $lineItem->description  = $line_item['description'];
            $lineItem->quantity     = $line_item['quantity'];
            $lineItem->price        = $line_item['price'];
            $lineItem->discount     = $line_item['discount'];
            $lineItem->vat          = $line_item['vat'];
            $lineItem->amount       = $line_item['amount'];
            $lineItem->save();
        }

        return redirect('sales/quotes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
