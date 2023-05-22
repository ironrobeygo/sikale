<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Quotes') }}
            </h2>

            <a href="{{ route('sales.quotes.create') }}" class="items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('New Quote') }}
            </a>
        </div>
        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Customer</th>
                                {{-- <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Status</th> --}}
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Due Date</th>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Amount</th>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotes as $quote)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    {{ $quote->customer->name }}
                                </td>
                                {{-- <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    {{ $quote->status }}
                                </td> --}}
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    {{ $quote->expiry_date }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    ZMK {{ number_format($quote->getAmount(), 2, '.',',') }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <ul class="flex gap-4">
                                        {{-- <li>
                                            <a href="{{ route('sales.quotes.show', ['quote' => $quote->id]) }}">Show</a>
                                        </li> --}}
                                        <li>
                                            <a href="{{ route('sales.quotes.edit', ['quote' => $quote->id]) }}">Edit</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('downloads.show', ['download' => $quote->id]) }}" target="_blank">Download</a>
                                        </li>
                                        {{-- <li>
                                            <form action="{{ route('sales.quotes.destroy', ['quote' => $quote->id]) }}" method="post">
                                                {{ method_field('delete') }}
                                                <button class="btn btn-default" type="submit">Delete</button>
                                            </form>
                                        </li> --}}
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
