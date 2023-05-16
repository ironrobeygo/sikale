<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <title>Sikale Wood Manufacturing</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>

    </head>

    <body>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div style="float: clear; overflow: auto;">

                        <div style="width: 584px; float: left;">
                            <h2><img src="{{ asset('/images/logo.jpg') }}"></h2>
                            <p>Plot No F/1938, PI Cnr. of Mungwi & Kasupe Road, Lusaka, Zambia</p>
                            <p>Email : accounts@sikalewood.com</p>
                            <p>TPIN : 1001858221</p>

                            <table style="margin-top: 20px;">
                                <tr>
                                    <td style="font-weight: 700;">Sold to:</td>
                                    <td style="padding-left: 10px;">{{ $quote['customer']['name'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 700;">Phone Number:</td>
                                    <td style="padding-left: 10px;">{{ $quote['customer']['phone'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 700;">Tax Number:</td>
                                    <td style="padding-left: 10px;">{{ $quote['customer']['tax_number'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 700;">Address:</td>
                                    <td style="padding-left: 10px;">{{ $quote['customer']['address'] }}, {{ $quote['customer']['city'] }}</td>
                                </tr>
                            </table>
                        </div>
                        <div style="width: 584px; float:right; text-align: right; margin-bottom: 20px">
                            <h1 style="font-size: 40px; font-weight: bold">QUOTE</h1>

                            <table class="width: 100%;">
                                <tr>
                                    <td class="font-bold">Quote Number: </td>
                                    <td class="pl-4">QSF-{{ $quote['id'] }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Issue Date: </td>
                                    <td class="pl-4">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $quote['issue_date'])->format('m/d/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Expiry Date: </td>
                                    <td class="pl-4">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $quote['expiry_date'])->format('m/d/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Reference: </td>
                                    <td class="pl-4">{{ $quote['reference'] }}</td>
                                </tr>
                            </table>
                        </div>
                    
                    </div>

                    <div style="padding-top: 20px;">
                        <table style="width: 100%; margin-top: 20px;">
                            <thead>
                                <tr>
                                    <th style="padding: 12px 6px; font-size: 12px; font-weight: 500; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280;">Item #</th>
                                    <th style="padding: 12px 6px; font-size: 12px; font-weight: 500; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280;">Description</th>
                                    <th style="padding: 12px 6px; font-size: 12px; font-weight: 500; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280;">Quantity</th>
                                    <th style="padding: 12px 6px; font-size: 12px; font-weight: 500; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280;">Price</th>
                                    <th style="padding: 12px 6px; font-size: 12px; font-weight: 500; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280;">Discount</th>
                                    <th style="padding: 12px 6px; font-size: 12px; font-weight: 500; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280;">VAT</th>
                                    <th style="padding: 12px 6px; font-size: 12px; font-weight: 500; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 0; @endphp
                                @foreach($lineItems as $lineItem)
                                <tr data-index="{{ $count }}">
                                    <td style="padding: 12px 6px; font-size: 14px; border-bottom: 1px solid #e5e7eb; text-align: center">
                                        {{ $count + 1 }}
                                    </td>
                                    <td style="padding: 12px 6px; font-size: 14px; border-bottom: 1px solid #e5e7eb; text-align: center">
                                        {{ $lineItem->description }}
                                    </td>
                                    <td style="padding: 12px 6px; font-size: 14px; border-bottom: 1px solid #e5e7eb; text-align: center">
                                        {{ $lineItem->quantity ?? 0 }}
                                    </td>
                                    <td style="padding: 12px 6px; font-size: 14px; border-bottom: 1px solid #e5e7eb; text-align: center">
                                        ZMK {{ $lineItem->price }}
                                    </td>
                                    <td style="padding: 12px 6px; font-size: 14px; border-bottom: 1px solid #e5e7eb; text-align: center">
                                        {{ $lineItem->discount ?? 0 }}
                                    </td>
                                    <td style="padding: 12px 6px; font-size: 14px; border-bottom: 1px solid #e5e7eb; text-align: center">
                                        ZMK {{ $lineItem->vat }}
                                    </td>
                                    <td style="padding: 12px 6px; font-size: 14px; border-bottom: 1px solid #e5e7eb; text-align: center">
                                        ZMK {{ $lineItem->amount }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div style="float: clear; overflow: auto; padding-bottom: 20px;">
                        <div style="width: 20%; float: right; padding-top: 20px;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="padding: 12px 6px; border-bottom: 1px solid #94a3b8;">Subtotal</td>
                                    <td style="padding: 12px 6px; border-bottom: 1px solid #94a3b8; text-align: right">ZMK {{ $subTotal }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 6px; font-size: 20px; ">Total</td>
                                    <td style="padding: 12px 6px; font-size: 20px; font-weight: bold; text-align: right;">ZMK {{ $amount }}</td>
                                </tr>
                            </table>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    </body>
</html>