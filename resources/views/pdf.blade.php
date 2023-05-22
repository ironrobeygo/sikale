<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <title>Sikale Wood Manufacturing</title>

        <style>
            *{ margin: 0; padding: 0 }
            body{ padding: 40px; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
            .float-clear{ float: clear; }
            .float-left{ float: left; }
            .float-right{ float: right; }
            .fs-20{ font-size: 20px; }
            .overflow-auto{ overflow: auto; }
            .w-584{ width: 584px; }
            .w-100{ width: 100%; }
            .mt-20{ margin-top: 20px; }
            .mb-20{ margin-bottom: 20px; }
            .fw-700{ font-weight: bold; }
            .pl-10{ padding-left: 10px; }
            .ta-right{text-align: right; }
            .ta-left{text-align: left; }
            .ta-center{text-align: center; }
            td{ font-family: Arial, Helvetica, sans-serif; } 
        </style>

    </head>

    <body>

        <table style="width: 100%;">
            <tr>
                <td>
                    <p style="font-size: 40px;"><span style="font-weight: bold; color: #70ad47;">Sikale</span> wood</p>
                    <p style="font-size: 20px; color: #c6e0b4;">manufacturers limited</p>
                </td>
                <td>
                    <p style="text-align: right; font-weight: bold; font-size: 16px;">QUOTE</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Plot No F/1938, PI Cnr. of Mungwi & Kasupe Road,<br>Lusaka, Zambia</p>
                    <p><strong>Email</strong> : accounts@sikalewood.com</p>
                    <p><strong>TPIN</strong> : 1001858221</p>
                    <br>
                    <table class="mt-20">
                        <tr>
                            <td class="fw-700" class="fw-700">Sold to:</td>
                            <td class="pl-10">{{ $quote['customer']['name'] }}</td>
                        </tr>
                        <tr>
                            <td class="fw-700">Phone Number:</td>
                            <td class="pl-10">{{ $quote['customer']['phone'] }}</td>
                        </tr>
                        <tr>
                            <td class="fw-700">Tax Number:</td>
                            <td class="pl-10">{{ $quote['customer']['tax_number'] }}</td>
                        </tr>
                        <tr>
                            <td class="fw-700">Address:</td>
                            <td class="pl-10">{{ $quote['customer']['address'] }}, {{ $quote['customer']['city'] }}</td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top;">
                    <table class="width: 100%;">
                        <tr>
                            <td class="fw-700">Quote Number: </td>
                            <td class="pl-10">QSF-{{ $quote['id'] }}</td>
                        </tr>
                        <tr>
                            <td class="fw-700">Issue Date: </td>
                            <td class="pl-10">{{ $issue_date }}</td>
                        </tr>
                        <tr>
                            <td class="fw-700">Expiry Date: </td>
                            <td class="pl-10">{{ $expiry_date }}</td>
                        </tr>
                        <tr>
                            <td class="fw-700">Reference: </td>
                            <td class="pl-10">{{ $quote['reference'] }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <br><br>

        <table>
            <tr>
                <td>
                    <p><span style="font-weight: bold;">Sales Person:</span> {{ $user }}</p>
                </td>
                <td></td>
            </tr>
        </table>

        <div style="padding-top: 10px;">
            <table style="width: 100%; margin-top: 20px; text-align: left;">
                <thead>
                    <tr>
                        <th style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; width: 2%;">#</th>
                        <th style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; width: 46%;">Description</th>
                        <th style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; width: 5%;">qty</th>
                        <th style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; width: 14%;">Price</th>
                        <th style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; width: 5%;">Disc.</th>
                        <th style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; width: 14%;">VAT</th>
                        <th style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; width: 14%;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php $count = 0; @endphp
                    @foreach($lineItems as $lineItem)
                    <tr data-index="{{ $count }}">
                        <td style="padding: 12px 6px; border-bottom: 1px solid #e5e7eb; text-align: center">
                            {{ $count + 1 }}
                        </td>
                        <td style="padding: 12px 6px; border-bottom: 1px solid #e5e7eb;">
                            {{ $lineItem->description }}
                        </td>
                        <td style="padding: 12px 6px; border-bottom: 1px solid #e5e7eb;">
                            {{ $lineItem->quantity ?? 0 }}
                        </td>
                        <td style="padding: 12px 6px; border-bottom: 1px solid #e5e7eb;">
                            ZMK {{ $lineItem->price }}
                        </td>
                        <td style="padding: 12px 6px; border-bottom: 1px solid #e5e7eb;">
                            {{ $lineItem->discount ?? 0 }}
                        </td>
                        <td style="padding: 12px 6px; border-bottom: 1px solid #e5e7eb;">
                            ZMK {{ $lineItem->vat }}
                        </td>
                        <td style="padding: 12px 6px; border-bottom: 1px solid #e5e7eb;">
                            ZMK {{ $lineItem->amount }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <table style="width: 100%; margin-top: 30px;">
            <tr>
                <td style="width: 50%;">
                    <ul style="list-style: none;">
                        <li>* This quote is valid for 7 days.  Acceptable minimum down payment is 50% of the quotation value.</li>
                        <li>*Please carefully check the order quantity, size, color, code and design before signing as any errors that may arise will be the client's responsibility.</li>
                        <li>*Sign on the quote confirming that the order is correct. The order will then be passed on to the factory for processing.</li>
                        <li>*Any goods not collected after order is complete will attract a storage fee of 5% of the total invoice amount per month.</li>
                        <li>*Goods can only be collected or delivered after the outstanding balance is fully settled.</li>
                    </ul>
                </td>
                <td style="vertical-align: top; width: 50%;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; font-weight: bold; ">Subtotal</td>
                            <td style="padding: 12px 6px; border-bottom: 1px solid #94a3b8; text-align: right">ZMK {{ $subTotal }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; font-weight: bold; ">Discount</td>
                            <td style="padding: 12px 6px; border-bottom: 1px solid #94a3b8; text-align: right">ZMK {{ $subTotal }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; font-weight: bold; ">Delivery</td>
                            <td style="padding: 12px 6px; border-bottom: 1px solid #94a3b8; text-align: right">ZMK {{ $delivery }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; font-weight: bold; ">VAT 16%</td>
                            <td style="padding: 12px 6px; border-bottom: 1px solid #94a3b8; text-align: right">ZMK {{ $vat }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; font-weight: bold; font-size: 20px; ">Total</td>
                            <td style="padding: 12px 6px; font-size: 20px; font-weight: bold; text-align: right;">ZMK {{ $amount }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <br>

        <table style="width: 100%; margin-top: 20px; font-family: Arial, Helvetica, sans-serif">
            <thead>
                <tr>
                    <th style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; width: 25%;">Bank Name: </th>
                    <th style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; width: 25%;">Stanbic Bank Zambia</th>
                    <th style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; width: 25%;">First National Bank</th>
                    <th style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; width: 25%;">First Capital Bank</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; width: 25%;" rowspan="2">Account Numbers :</td>
                    <td style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; width: 25%;">9130004033586 ZMW</td>
                    <td style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; width: 25%;">62695804677 ZMW</td>
                    <td style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; width: 25%;">0002203001686 ZMW</td>
                </tr>
                <tr>
                    <td style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; width: 25%;">9130004033624 USD</td>
                    <td style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; width: 25%;"></td>
                    <td style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; width: 25%;">0002205004465 USD</td>
                </tr>
                <tr>
                    <td style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; width: 25%;">Branch Name :</td>
                    <td style="padding: 12px 6px; text-align: left; border-bottom: 1px solid #e5e7eb; width: 25%;">Arcades Branch</td>
                    <td style="padding: 12px 6px; text-align: left; border-bottom: 1px solid #e5e7eb; width: 25%;">Commercial Branch</td>
                    <td style="padding: 12px 6px; text-align: left; border-bottom: 1px solid #e5e7eb; width: 25%;">Cairo Branch</td>
                </tr>
                <tr>
                    <td style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; width: 25%;">Sort Code :</td>
                    <td style="padding: 12px 6px; text-align: left; border-bottom: 1px solid #e5e7eb; width: 25%;">040010</td>
                    <td style="padding: 12px 6px; text-align: left; border-bottom: 1px solid #e5e7eb; width: 25%;">260001</td>
                    <td style="padding: 12px 6px; text-align: left; border-bottom: 1px solid #e5e7eb; width: 25%;">280002</td>
                </tr>
                <tr>
                    <td style="padding: 12px 6px; text-align: left; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; background: #f9fafb; color: #6b7280; width: 25%;">Swift Code :</td>
                    <td style="padding: 12px 6px; text-align: left; border-bottom: 1px solid #e5e7eb; font-family: Arial, Arial, Helvetica, sans-serif; width: 25%;">SBICZMLX</td>
                    <td style="padding: 12px 6px; text-align: left; border-bottom: 1px solid #e5e7eb; font-family: Arial, Arial, Helvetica, sans-serif; width: 25%;">FIRNZMLX</td>
                    <td style="padding: 12px 6px; text-align: left; border-bottom: 1px solid #e5e7eb; font-family: Arial, Arial, Helvetica, sans-serif; width: 25%;">FRCGZMLU</td>
                </tr>
            </tbody>
        </table>
    
    </body>
</html>