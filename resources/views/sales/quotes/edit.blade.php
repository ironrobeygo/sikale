@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
         $(document).ready(function () {
            const formatter = new Intl.NumberFormat('en');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.js-data-example-ajax').select2();

            $('.js-data-example-ajax').select2({
                dateFormat: 'd-m-Y',
                placeholder: "Select a customer",
                minimumInputLength: 3,
                ajax: {
                    url: '/ajax/customers',
                    type: 'GET',
                    dataType: 'json',
                    data: function (params){
                        var query = {
                            search: params.term
                        }

                        return query;
                    },
                    processResults: function (response) {

                        return {
                            results: response.data
                        };

                    },
                }
            });

            $('#expiry_date').datepicker();

            $( "#issue_date" ).datepicker({
                minDate: 0,
                onSelect: function (date, datepicker){
                    var newDate = $(this).datepicker('getDate');
                    newDate.setDate(newDate.getDate() + 7);

                    $('#expiry_date').datepicker('setDate', newDate).datepicker('option', 'minDate', newDate); 
                }
            });

            $('#items').on('click', '.trash', function(){
                let index = $(this).parent().parent().data('index');
                
                let trLines = $(this).parent().parent().parent().children('tr').length - 1

                $('#items tbody tr:eq('+index+')').remove();

                findTotal(trLines)
                findDiscount(trLines)
                findVat(trLines)
                findSubtotal(trLines)
            })

            $('#items').on('change', '.line-items', function(){
                let index = $(this).parent().parent().data('index');
                let priceName = '.'+index+'_price';
                let quantityName = '.'+index+'_quantity';
                let disc = '.'+index+'_disc';
                let discountName = '.'+index+'_discount';
                let vatName = '.'+index+'_vat';
                let amountName = '.'+index+'_amount';
                
                let price = $(priceName).val() ?? 0;
                let quantity = $(quantityName).val() ?? 0;
                let discount = $(discountName).val() ?? 0;

                let amount = quantity * Number(price.replace(/\,/g,''));

                $(disc).val(0)

                if(discount > 0 ){
                    let discountValue = (amount * (discount/100))
                    $(disc).val(discountValue)
                    amount = amount - discountValue
                } 

                let vat = (amount * 16)/116;

                $(amountName).val(formatter.format(amount.toFixed(2)));
                $(vatName).val(formatter.format(vat.toFixed(2)));

                findTotal()
                findDiscount()
                findVat()
                findSubtotal()
            })

            $('.js-data-example-ajax').on('select2:select', function (e) {
                $('#customer_id').val(e.params.data.id)
            });

            $('#addRow').click(function(e){
                e.preventDefault();
                let counts = $('#items tbody tr').length;

                let html = '<tr data-index="'+counts+'">';
                        html += '<td class="whitespace-no-wrap border-b border-gray-200 text-center">';
                            html += counts + 1;
                        html += '</td>';
                        html += '<td class="whitespace-no-wrap border-b border-gray-200">';
                            html += '<input type="text" name="line_items['+counts+'][description]" requied class="w-full border-none line-items">';
                        html += '</td>';
                        html += '<td class="whitespace-no-wrap border-b border-gray-200">';
                            html += '<input type="num" min="0" name="line_items['+counts+'][quantity]" requied class="w-full p-1 focus:border-none line-items '+counts+'_quantity">';
                        html += '</td>';
                        html += '<td class="whitespace-no-wrap border-b border-gray-200">';
                            html += '<input type="num" min="0" name="line_items['+counts+'][price]" requied class="w-full line-items '+counts+'_price">';
                        html += '</td>';
                        html += '<td class="whitespace-no-wrap border-b border-gray-200">';
                            html += '<input type="hidden" name="line_items['+counts+'][disc]" class="'+counts+'_disc">';
                            html += '<input type="num" min="0" name="line_items['+counts+'][discount]" requied class="w-full line-items '+counts+'_discount">';
                        html += '</td>';
                        html += '<td class="whitespace-no-wrap border-b border-gray-200">';
                            html += '<input type="num" min="0" name="line_items['+counts+'][vat]" requied class="w-full '+counts+'_vat" readonly>';
                        html += '</td>';
                        html += '<td class="whitespace-no-wrap border-b border-gray-200">';
                            html += '<input type="num" min="0" name="line_items['+counts+'][amount]" requied class="w-full '+counts+'_amount" readonly>';
                        html += '</td>';
                        html += '<td class="whitespace-no-wrap border-b border-gray-200">';
                            html += '<span class="trash cursor-pointer" data-index="'+counts+'">Trash</span>';
                        html += '</td>';
                    html += '</tr>';
                
                $('#items tbody').append(html);
            })

            $('#delivery_value').change(function(){
                findTotal()
            })

            function findTotal(){
                let total = parseFloat(0)
                let lines = $('#items tbody tr').length - 1
                let delivery_value = $('#delivery_value').val()

                for(let i = 0; i <= lines; i++){
                    let val = $('.'+i+'_amount').val()
                    total = total + Number(val.replace(/\,/g,''))
                }

                total = parseInt(total) + parseInt(delivery_value)

                totalValue = total
                $('.total_value').text(formatter.format(total.toFixed(2)))
            }

            function findVat(){
                let vat = parseFloat(0)
                let lines = $('#items tbody tr').length - 1

                for(let i = 0; i <= lines; i++){
                    let val = $('.'+i+'_vat').val()
                    vat = vat + Number(val.replace(/\,/g,''))
                }
                vatValue = vat
                $('.vat_value').text(formatter.format(vat.toFixed(2)))
            }

            function findDiscount(){
                let disc = parseFloat(0)
                let lines = $('#items tbody tr').length - 1
                
                for(let i = 0; i <= lines; i++){
                    let val = $('.'+i+'_disc').val()
                    disc = disc + Number(val.replace(/\,/g,''))
                }
                discValue = disc
                $('.discount_value').text(formatter.format(disc.toFixed(2)))
            }

            function findSubtotal(){
                subtotalValue = Number(totalValue) - Number(vatValue)
                $('.subtotal_value').text(formatter.format(subtotalValue.toFixed(2)))
            }

         });
    </script>
    <style>
        .select2-container{
            margin-top: 4px;
            border-radius: 6px;
        }
    </style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Quote') }}
            </h2>
            
            <a href="{{ route('sales.quotes.index') }}" class="items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Back to Quotes') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="post" action="/sales/quotes/{{ $quote->id }}" class="space-y-6">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="customer_id" id="customer_id" value="{{ $quote->customer_id }}">
                        <div class="border-b-2 border-slate-400 mb-6">
                            <h3 class="font-semibold">Billing</h3>
                            <p class="mb-6">Billing details appear in your invoice. Invoice Date is used in the dashboard and reports. Select the date you expect to get paid as the Due Date.</p>
                        </div>

                        <div class="flex gap-6">
                            <div class="w-1/3">
                                <x-input-label for="customer" :value="__('Customer')" />
                                <x-text-input id="customer" name="customer" type="text" class="mt-1 block w-full" value="{{ $quote->customer->name }}" disabled />
                            </div>

                            <div class="w-1/3 space-y-6">
                                <div>
                                    <x-input-label for="issue_date" :value="__('Issue Date')" />
                                    <x-text-input id="issue_date" name="issue_date" type="text" class="mt-1 block w-full" required autofocus autocomplete="issue_date" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $quote->issue_date)->format('m/d/Y') }}"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('issue_date')" />
                                </div>

                                <div>
                                    <x-input-label for="expiry_date" :value="__('Expiry Date')" />
                                    <x-text-input id="expiry_date" name="expiry_date" type="text" class="mt-1 block w-full" required autofocus autocomplete="expiry_date"  value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $quote->expiry_date)->format('m/d/Y') }}"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('expiry_date')" />
                                </div>
                            </div>

                            <div class="w-1/3 space-y-6">
                                <div>
                                    <x-input-label for="quote" :value="__('Quote Number')" />
                                    <x-text-input id="quote" name="quote" type="text" class="mt-1 block w-full" placeholder="QSF-XXX" required autofocus readonly value="QSF-{{ $quote->id }}"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('quote')" />
                                </div>

                                <div>
                                    <x-input-label for="reference" :value="__('Reference Number')" />
                                    <x-text-input id="reference" name="reference" type="text" class="mt-1 block w-full" autofocus value="{{ $quote->reference }}"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('reference')" />
                                </div>
                            </div>

                        </div>

                        <br>

                        <div class="border-b-2 border-slate-400 mb-6 mt-8">
                            <h3 class="font-semibold">Items</h3>
                        </div>

                        <div>
                            <table id="items" class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="py-3 text-xs font-medium leading-4 tracking-wider text-center text-gray-500 uppercase border-b border-gray-200 bg-gray-50">#</th>
                                        <th class="py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Description</th>
                                        <th class="w-[5%] py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Qty</th>
                                        <th class="w-[10%] py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Price</th>
                                        <th class="w-[10%] py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Disc</th>
                                        <th class="w-[10%] py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">VAT</th>
                                        <th class="w-[10%] py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Amount</th>
                                        <th class="w-[5%] py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 0; @endphp
                                    @foreach($quote->lineItems as $lineItem)
                                    <tr data-index="{{ $count }}">
                                        <td class="whitespace-no-wrap border-b border-gray-200 text-center">
                                            <input type="hidden" name="line_items[{{ $count }}][id]" value="{{ $lineItem->id }}">
                                            {{ $count + 1 }}
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="text" name="line_items[{{ $count }}][description]" requied class="w-full border-none line-items" value="{{ $lineItem->description }}">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[{{ $count }}][quantity]" requied class="w-full p-1 focus:border-none line-items {{ $count }}_quantity" value="{{ $lineItem->quantity ?? 0 }}">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[{{ $count }}][price]" requied class="w-full line-items {{ $count }}_price" value="{{ $lineItem->price }}">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="hidden" name="line_items[{{ $count }}][disc]" requied class="{{ $count }}_disc" value="{{ $lineItem->disc ?? 0 }}">
                                            <input type="num" min="0" name="line_items[{{ $count }}][discount]" requied class="w-full line-items {{ $count }}_discount" value="{{ $lineItem->discount ?? 0 }}">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[{{ $count }}][vat]" requied class="w-full {{ $count }}_vat" readonly value="{{ $lineItem->vat }}">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[{{ $count }}][amount]" requied class="w-full {{ $count }}_amount" readonly value="{{ $lineItem->amount }}">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            @if($count > 0)
                                            <span class="trash cursor-pointer" data-index="{{ $count }}">Trash</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @php  $count++ @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <x-secondary-button id="addRow" class="mt-5">{{ __('Add Row') }}</x-primary-button>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-xs">
                                <ul>
                                    <li>* This quote is valid for 7 days.  Acceptable minimum down payment is 50% of the quotation value.</li>
                                    <li>*Please carefully check the order quantity, size, color, code and design before signing as any errors that may arise will be the client's responsibility.</li>
                                    <li>*Sign on the quote confirming that the order is correct. The order will then be passed on to the factory for processing.</li>
                                    <li>*Any goods not collected after order is complete will attract a storage fee of 5% of the total invoice amount per month.</li>
                                    <li>*Goods can only be collected or delivered after the outstanding balance is fully settled.</li>
                                </ul>
                            </div>
                            <table>
                                <tr>
                                    <td class="py-3 border-b border-slate-400">Subtotal (excluding VAT)</td>
                                    <td class="py-3 border-b border-slate-400 text-right">ZMK <span class="subtotal_value">{{ number_format($quote->getSubTotal(), 2, '.',',') }}</span></td>
                                </tr>
                                <tr>
                                    <td class="py-3 border-b border-slate-400">Discount</td>
                                    <td class="py-3 border-b border-slate-400 text-right">ZMK <span class="discount_value">{{ number_format($quote->getDiscValue(), 2, '.',',') }}</span></td>
                                </tr>                                
                                <tr>
                                    <td class="py-3 border-b border-slate-400">Delivery</td>
                                    <td class="py-3 border-b border-slate-400 text-right">ZMK <input type="text" name="delivery_value" id="delivery_value" value="{{ number_format($quote->delivery) }}"/></td>
                                </tr>
                                <tr>
                                    <td class="py-3 border-b border-slate-400">VAT 16%</td>
                                    <td class="py-3 border-b border-slate-400 text-right">ZMK <span class="vat_value">{{ number_format($quote->getVAT(), 2, '.',',') }}</span></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td class="text-right font-bold text-2xl">ZMK <span class="total_value">{{ number_format($quote->getAmount(), 2, '.',',') }}</span></td>
                                </tr>
                            </table>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
