@extends('admin.layouts.app')

@section('content')
<div class="py-12">
  <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
      Edit Catalog
    </h2>

    <x-partials.card>
      <x-slot name="title">
        <a href="{{ route('catalog.index') }}" class="mr-4"><i class="fad fa-arrow-left"></i></a>
      </x-slot>

      <form method="POST" action="{{ route('catalog.update', $catalog->id) }}" class="mt-4"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Use PUT for update -->

        <div class="flex flex-wrap">

          <div class="my-2 w-full">
            <label class="label font-medium text-gray-700 block mb-2" for="name"> Name </label>
            <input type="text" id="name" name="name" value="{{ old('name', $catalog->name) }}"
              class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none @error('name') border-red-500 @enderror"
              maxlength="255" placeholder="Ex: Pizza" required autocomplete="off">
            @error('name')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="my-2 w-full">
            <label class="label font-medium text-gray-700 block mb-2" for="restaurant">Restaurant </label>
            <select name="restaurant" id="restaurant"
              class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none @error('restaurant') border-red-500 @enderror">
              <option value="" {{ old('restaurant', $catalog->restaurant_id) == '' ? 'selected' : '' }}>-Select-
              </option>
              @foreach ($restaurants as $restaurant)
              <option value="{{ $restaurant->id }}"
                {{ old('restaurant', $catalog->restaurant_id) == $restaurant->id ? 'selected' : '' }}>
                {{ $restaurant->name }}
              </option>
              @endforeach
            </select>
            @error('restaurant')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="my-2 w-full">
            <label class="label font-medium text-gray-700 block mb-2" for="display_order"> Display Order </label>
            <input type="number" id="display_order" name="display_order"
              value="{{ old('display_order', $catalog->display_order) }}"
              class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none @error('display_order') border-red-500 @enderror"
              placeholder="Ex:1" required autocomplete="off">
            @error('display_order')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>
          
        </div>

        <div class="mt-10">
          <a href="{{ route('catalog.index') }}"
            class="px-4 py-3 mt-4 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 hover:text-gray-700 mr-1">
            <i class="fa-duotone fa-arrow-left"></i> Back to Index
          </a>
          <button type="submit"
            class="rounded bg-primary px-6 py-3 font-medium hover:bg-opacity-90 text-white float-right">
            <i class="mr-1 fa-duotone fa-floppy-disk"></i> Update
          </button>
        </div>
      </form>

    </x-partials.card>
  </div>
</div>
@endsection