<?php

namespace App\Http\Controllers\Sales;

use Carbon\Carbon;
use App\Models\Quote;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class QuoteDownloadController extends Controller
{
    public function show(){
        $quote = Quote::with('customer')->where('id', 1)->first();
        $lineItems = $quote->lineItems;
        $issue_date = Carbon::createFromFormat('Y-m-d', $quote['issue_date'])->format('m/d/Y');
        $expiry_date = Carbon::createFromFormat('Y-m-d', $quote['expiry_date'])->format('m/d/Y');
        $subTotal = $quote->getSubTotal();
        $delivery = $quote->delivery;
        $vat = $quote->getVAT();
        $amount = $quote->getAmount();

        $pdf = Pdf::loadView('pdf', [
            'quote' => $quote->toArray(),
            'lineItems' => $lineItems,
            'issue_date' => $issue_date,
            'expiry_date' => $expiry_date,
            'subTotal' => $subTotal,
            'delivery' => $delivery,
            'vat' => $vat,
            'amount' => $amount,
            'user' => auth()->user()->name
        ]);
        return $pdf->stream();
    }
}
