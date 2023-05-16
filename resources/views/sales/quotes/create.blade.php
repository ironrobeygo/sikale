@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
         $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.js-data-example-ajax').select2();

            $('.js-data-example-ajax').select2({
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

            $('.line-items').change(function(){
                let index = $(this).parent().parent().data('index');
                let priceName = '.'+index+'_price';
                let quantityName = '.'+index+'_quantity';
                let discountName = '.'+index+'_discount';
                let vatName = '.'+index+'_vat';
                let amountName = '.'+index+'_amount';
                let trLines = $(this).parent().parent().parent().children('tr').length - 1
                
                let price = $(priceName).val() ?? 0;
                let quantity = $(quantityName).val() ?? 0;
                let discount = $(discountName).val() ?? 0;

                
                let amount = quantity * price;

                if(discount > 0 ){
                    let discountValue = (amount * (discount/100))
                    amount = amount - discountValue
                } 

                let vat = (amount * 16)/116;

                $(amountName).val(amount);
                $(vatName).val(vat.toFixed(2));

                findSubtotal(trLines)
                findTotal(trLines)

            });

            $('.js-data-example-ajax').on('select2:select', function (e) {
                $('#customer_id').val(e.params.data.id)
            });

            function findSubtotal(lines){
                let subTotal = parseFloat(0)
                for(let i = 0; i <= lines; i++){
                    let val = $('.'+i+'_vat').val()
                    subTotal = subTotal + Number(val)
                }

                $('.subtotal_value').text(subTotal)
            }

            function findTotal(lines){
                let total = parseFloat(0)
                for(let i = 0; i <= lines; i++){
                    let val = $('.'+i+'_amount').val()
                    total = total + Number(val)
                }

                $('.total_value').text(total)
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
                {{ __('New Quote') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="post" action="{{ route('sales.quotes.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="customer_id" id="customer_id">
                        <div class="border-b-2 border-slate-400 mb-6">
                            <h3 class="font-semibold">Billing</h3>
                            <p class="mb-6">Billing details appear in your invoice. Invoice Date is used in the dashboard and reports. Select the date you expect to get paid as the Due Date.</p>
                        </div>

                        <div class="flex gap-6">
                            <div class="w-1/3">
                                <x-input-label for="customer" :value="__('Customer')" />
                                <select class="js-data-example-ajax" style="width: 100%; margin-top: 4px;">
                                    <option></option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-1/3 space-y-6">
                                <div>
                                    <x-input-label for="issue_date" :value="__('Issue Date')" />
                                    <x-text-input id="issue_date" name="issue_date" type="text" class="mt-1 block w-full" required autofocus autocomplete="issue_date" />
                                    <x-input-error class="mt-2" :messages="$errors->get('issue_date')" />
                                </div>

                                <div>
                                    <x-input-label for="expiry_date" :value="__('Expiry Date')" />
                                    <x-text-input id="expiry_date" name="expiry_date" type="text" class="mt-1 block w-full" required autofocus autocomplete="expiry_date" />
                                    <x-input-error class="mt-2" :messages="$errors->get('expiry_date')" />
                                </div>
                            </div>

                            <div class="w-1/3 space-y-6">
                                <div>
                                    <x-input-label for="quote" :value="__('Quote Number')" />
                                    <x-text-input id="quote" name="quote" type="text" class="mt-1 block w-full" placeholder="QSF-XXX" required autofocus readonly />
                                    <x-input-error class="mt-2" :messages="$errors->get('quote')" />
                                </div>

                                <div>
                                    <x-input-label for="reference" :value="__('Reference Number')" />
                                    <x-text-input id="reference" name="reference" type="text" class="mt-1 block w-full" autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('reference')" />
                                </div>
                            </div>

                        </div>

                        <br>

                        <div class="border-b-2 border-slate-400 mb-6 mt-8">
                            <h3 class="font-semibold">Items</h3>
                        </div>

                        <div>
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Item #</th>
                                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Description</th>
                                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Quantity</th>
                                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Price</th>
                                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Discount</th>
                                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">VAT</th>
                                        <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-index="0">
                                        <td class="whitespace-no-wrap border-b border-gray-200 text-center">
                                            1
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="text" name="line_items[0][description]" requied class="w-full border-none line-items">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[0][quantity]" requied class="w-full p-1 focus:border-none line-items 0_quantity">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[0][price]" requied class="w-full line-items 0_price">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[0][discount]" requied class="w-full line-items 0_discount">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[0][vat]" requied class="w-full 0_vat" readonly>
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[0][amount]" requied class="w-full 0_amount" readonly>
                                        </td>
                                    </tr>
                                    <tr data-index="1">
                                        <td class="whitespace-no-wrap border-b border-gray-200 text-center">
                                            2
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="text" name="line_items[1][description]" class="w-full border-none">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[1][quantity]" class="w-full p-1 focus:border-none line-items 1_quantity">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[1][price]" class="w-full line-items 1_price">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[1][discount]" class="w-full line-items 1_discount">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[1][vat]" class="w-full 1_vat" readonly>
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[1][amount]" class="w-full 1_amount" readonly>
                                        </td>
                                    </tr>
                                    <tr data-index="2">
                                        <td class="whitespace-no-wrap border-b border-gray-200 text-center">
                                            3
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="text" name="line_items[2][description]" class="w-full border-none">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[2][quantity]" class="w-full p-1 focus:border-none line-items 2_quantity">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[2][price]" class="w-full line-items 2_price">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[2][discount]" class="w-full line-items 2_discount">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[2][vat]" class="w-full 2_vat" readonly>
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[2][amount]" class="w-full 2_amount" readonly>
                                        </td>
                                    </tr>
                                    <tr data-index="3">
                                        <td class="whitespace-no-wrap border-b border-gray-200 text-center">
                                            4
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="text" name="line_items[3][description]" class="w-full border-none">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[3][quantity]" class="w-full p-1 focus:border-none line-items 3_quantity">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[3][price]" class="w-full line-items 3_price">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[3][discount]" class="w-full line-items 3_discount">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[3][vat]" class="w-full 3_vat" readonly>
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[3][amount]" class="w-full 3_amount" readonly>
                                        </td>
                                    </tr>
                                    <tr data-index="4">
                                        <td class="whitespace-no-wrap border-b border-gray-200 text-center">
                                            5
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="text" name="line_items[4][description]" class="w-full border-none">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[4][quantity]" class="w-full p-1 focus:border-none line-items 4_quantity">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[4][price]" class="w-full line-items 4_price">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[4][discount]" class="w-full line-items 4_discount">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[4][vat]" class="w-full 4_vat" readonly>
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[4][amount]" class="w-full 4_amount" readonly>
                                        </td>
                                    </tr>
                                    <tr data-index="5">
                                        <td class="whitespace-no-wrap border-b border-gray-200 text-center">
                                            6
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="text" name="line_items[5][description]" class="w-full border-none">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[5][quantity]" class="w-full p-1 focus:border-none line-items 5_quantity">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[5][price]" class="w-full line-items 5_price">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[5][discount]" class="w-full line-items 5_discount">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[5][vat]" class="w-full 5_vat" readonly>
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[5][amount]" class="w-full 5_amount" readonly>
                                        </td>
                                    </tr>
                                    <tr data-index="6">
                                        <td class="whitespace-no-wrap border-b border-gray-200 text-center">
                                            7
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="text" name="line_items[6][description]" class="w-full border-none">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[6][quantity]" class="w-full p-1 focus:outline-none line-items 6_quantity">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[6][price]" class="w-full line-items 6_price">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[6][discount]" class="w-full line-items 6_discount">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[6][vat]" class="w-full 6_vat" readonly>
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[6][amount]" class="w-full 6_amount" readonly>
                                        </td>
                                    </tr>
                                    <tr data-index="7">
                                        <td class="whitespace-no-wrap border-b border-gray-200 text-center">
                                            8
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="text" name="line_items[7][description]" class="w-full border-none">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[7][quantity]" class="w-full p-1 focus:border-none line-items 7_quantity">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[7][price]" class="w-full line-items 7_price">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[7][discount]" class="w-full line-items 7_discount">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[7][vat]" class="w-full 7_vat" readonly>
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[7][amount]" class="w-full 7_amount" readonly>
                                        </td>
                                    </tr>
                                    <tr data-index="8">
                                        <td class="whitespace-no-wrap border-b border-gray-200 text-center">
                                            9
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="text" name="line_items[8][description]" class="w-full border-none">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[8][quantity]" class="w-full p-1 focus:border-none line-items 8_quantity">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[8][price]" class="w-full line-items 8_price">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[8][discount]" class="w-full line-items 8_discount">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[8][vat]" class="w-full 8_vat" readonly>
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[8][amount]" class="w-full 8_amount" readonly>
                                        </td>
                                    </tr>
                                    <tr data-index="9">
                                        <td class="whitespace-no-wrap border-b border-gray-200 text-center">
                                            10
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="text" name="line_items[9][description]" class="w-full border-none">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[9][quantity]" class="w-full p-1 focus:border-none line-items 9_quantity">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[9][price]" class="w-full line-items 9_price">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[9][discount]" class="w-full line-items 9_discount">
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[9][vat]" class="w-full 9_vat" readonly>
                                        </td>
                                        <td class="whitespace-no-wrap border-b border-gray-200">
                                            <input type="num" min="0" name="line_items[9][amount]" class="w-full 9_amount" readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <table>
                                <tr>
                                    <td class="border-b border-slate-400">Subtotal</td>
                                    <td class="border-b border-slate-400 text-right">ZMK <span class="subtotal_value"></span></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td class="text-right font-bold text-2xl">ZMK <span class="total_value"></span></td>
                                </tr>
                            </table>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
