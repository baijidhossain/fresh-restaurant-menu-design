@extends('admin.layouts.app')
@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
                Generate QR Code
            </h2>
            <x-partials.card>


                <form class="grid md:grid-cols-2 gap-4" id="qrCodeForm" onsubmit="generateQRCode(event)">

                    <div class="md:col-span-1">
                        <label class="block text-gray-600 text-sm mb-1" for="firstname">Firstname</label>
                        <input
                            class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                            id="firstname" type="text" name="firstname" value="" required>
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-gray-600 text-sm mb-1" for="lastname">Lastname</label>
                        <input
                            class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                            id="lastname" type="text" name="lastname" value="" required>
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-gray-600 text-sm mb-1" for="organization">Organization</label>
                        <input
                            class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                            id="organization" type="text" name="organization" value="">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-gray-600 text-sm mb-1" for="position">Position</label>
                        <input
                            class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                            id="position" type="text" name="position" value="">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-gray-600 text-sm mb-1" for="phoneWork">Phone (Work)</label>
                        <input
                            class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                            id="phoneWork" type="tel" name="phone_work" value="">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-gray-600 text-sm mb-1" for="phonePrivate">Phone (Private)</label>
                        <input
                            class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                            id="phonePrivate" type="tel" name="phone_private" value="" required>
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-gray-600 text-sm mb-1" for="faxWork">Fax (Work)</label>
                        <input
                            class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                            id="faxWork" type="tel" name="fax_work" value="">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-gray-600 text-sm mb-1" for="email">Email</label>
                        <input
                            class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                            id="email" type="email" name="email" value="">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-gray-600 text-sm mb-1" for="website">Website</label>
                        <input
                            class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                            id="website" type="url" name="website" value="">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-gray-600 text-sm mb-1" for="street">Street</label>
                        <input
                            class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                            id="street" type="text" name="street" value="">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-gray-600 text-sm mb-1" for="zipcode">Zipcode</label>
                        <input
                            class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                            id="zipcode" type="text" name="zipcode" value="">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-gray-600 text-sm mb-1" for="city">City</label>
                        <input
                            class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                            id="city" type="text" name="city" value="">
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-gray-600 text-sm mb-1" for="state">State</label>
                        <input
                            class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                            id="state" type="text" name="state" value="">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-gray-600 text-sm mb-1" for="country">Country</label>
                        <input
                            class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                            id="country" type="text" name="country" value="">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-gray-600 text-sm mb-1">Notes</label>
                        <div id="notes-container">
                            <div class="note-item flex items-center mb-2">
                            </div>
                        </div>
                        <button type="button" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded"
                            onclick="addNote()">Add Note</button>
                    </div>


                </form>

                <div class="flex items-center justify-center">
                    <div id="qrcode-canvas"></div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-3 mt-4 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 hover:text-gray-700 mr-1">
                        <i class="mr-1 fa-light fa-arrow-left"></i>
                        Back
                    </a>
                    <button class="rounded bg-primary px-6 py-3 font-medium hover:bg-opacity-90 text-white" type="submit"
                        form="qrCodeForm">
                        <i class="mr-1 fa-duotone fa-qrcode"></i>
                        Generate QR Code
                    </button>
                </div>
            </x-partials.card>
        </div>
    </div>
@endsection


@push('scripts')
    @vite('resources/js/qrcode-generator.js')
@endpush
