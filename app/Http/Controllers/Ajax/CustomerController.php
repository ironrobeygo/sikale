<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller
{
    public function index(Request $request){

        $customers = Customer::when(request()->search, function($query){
            $query->where('name', 'LIKE', '%'.request()->search.'%');
        })
        ->get();

        return CustomerResource::collection($customers);
    }

}
