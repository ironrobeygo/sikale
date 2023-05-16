<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Customer') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="post" action="{{ route('sales.customers.update', ['customer' => $customer->id]) }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div class="border-b-2 border-slate-400 mb-6">
                            <h3 class="font-semibold">General</h3>
                            <p class="mb-6">Your client's contact information will appear in invoices and their profiles.</p>
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" :value="old('name', $customer->name)"/>
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="email"  :value="old('email', $customer->email)"/>
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" required autocomplete="phone"  :value="old('phone', $customer->phone)"/>
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>

                        <br>

                        <div class="border-b-2 border-slate-400 mb-6 mt-8">
                            <h3 class="font-semibold">Billing</h3>
                            <p class="mb-6">The tax number appears in every invoice issued to the customer.</p>
                        </div>

                        <div>
                            <x-input-label for="tax_number" :value="__('Tax Number')" />
                            <x-text-input id="tax_number" name="tax_number" type="text" class="mt-1 block w-full" required autofocus autocomplete="tax_number"  :value="old('tax_number', $customer->tax_number)"/>
                            <x-input-error class="mt-2" :messages="$errors->get('tax_number')" />
                        </div>

                        <br>

                        <div class="border-b-2 border-slate-400 mb-6 mt-8">
                            <h3 class="font-semibold">Address</h3>
                            <p class="mb-6">The address is required for the invoices, so you need to add billing address details for your customer.</p>
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Address')" />
                            <textarea id="address" name="address" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" autofocus autocomplete="address">{{ $customer->address }}</textarea>
                        </div>

                        <div class="flex gap-6">
                            <div class="w-1/2">
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" autofocus autocomplete="city"  :value="old('city', $customer->city)" />
                            </div>
                            <div class="w-1/2">
                                <x-input-label for="postal" :value="__('Postal / Zip Code')" />
                            <x-text-input id="postal" name="postal" type="text" class="mt-1 block w-full" autofocus autocomplete="postal"  :value="old('postal', $customer->postal)"/>
                            </div>

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
