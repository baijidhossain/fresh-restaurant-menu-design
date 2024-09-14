@extends('admin.layouts.app')
@section('content')


  <div class="py-12 px-12">

    <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
      {{-- @lang('crud.rastaurant.index_title') --}}
      Restaurant Lists
    </h2>

    <x-partials.card>
      <div class="mb-5 mt-4">
        <div class="flex flex-wrap justify-between">
          <div class="md:w-1/2">
            <form>
              <div class="flex items-center w-full">
                <x-inputs.text name="search" value="{{ $search ?? '' }}" placeholder="{{ __('crud.common.search') }}"
                  autocomplete="off"></x-inputs.text>

                <div class="ml-1">
                  <button type="submit" class="rounded bg-primary px-6 py-3 font-medium hover:bg-opacity-90 text-white">
                    <i class="fa-duotone fa-magnifying-glass"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
          <div class="md:w-1/2 text-right">
            @can('create', App\Models\restaurants::class)
            <a href="{{ route('restaurant.create') }}"
              class="rounded bg-primary px-6 py-3 font-medium hover:bg-opacity-90 text-white">
              <i class="mr-1 fa-duotone fa-circle-plus"></i>
              @lang('crud.common.create')
            </a>
            @endcan
          </div>
        </div>
      </div>

      <div class="block w-full overflow-auto scrolling-touch">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:text-gray-400">

            <tr class="bg-gray-50">
              <th class="px-4 py-3 " style="width: 50px;"> S/N </th>
              <th class="px-4 py-3 " style="width: 100px;"> Logo </th>
              <th class="px-4 py-3 " style="width: 250px;"> Name </th>
              <th class="px-4 py-3 " style="width: 120px;"> Start Time </th>
              <th class="px-4 py-3 " style="width: 120px;"> End Time </th>
              <th class="px-4 py-3 " style="width: 170px;"> Created At </th>
              <th class="px-4 py-3 " style="width: 150px;">Action</th>
            </tr>

          </thead>

          <tbody>

            @forelse ($restaurants as $restaurant)
            <tr>
              <td class="px-4 py-3">{{ $restaurant->serial_index }}</td>
              <td class="px-4 py-3">
                
                <img src="{{ $restaurant->logo ? \Storage::url("restaurant/logos/".$restaurant->logo) : \Storage::url('default/restaurant-logo-pleaceholder.png') }}"
                  alt="{{ $restaurant->name }} logo" style="width: 50px; height: auto;">
                
                </td>
              <td class="px-4 py-3"> <a class="font-semibold text-indigo-600" href="{{ route('restaurant.view',$restaurant->id) }}">{{ $restaurant->name }}</a> </td>

              <td class="px-4 py-3">{{ date_create($restaurant->start_time)->format('g:i A') }}</td>

              <td class="px-4 py-3">{{ date_create($restaurant->end_time)->format('g:i A') }}</td>

              <td class="px-4 py-3">{{ date_create($restaurant->created_at)->format('Y-m-d H:i:s') }}</td>

              <td class="px-4 py-3 text-center" style="width: 134px;">
                
                <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle ">

                  <a href="{{ route('restaurant.edit',$restaurant->id) }}" class="mr-1">
                    <button type="button"
                      class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">
                      <i class="fa-duotone fa-pencil"></i>
                    </button>
                  </a>

                  <a href="{{ route('restaurant.view',$restaurant->id) }}" class="mr-1">
                    <button type="button"
                      class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-success border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">
                      <i class="fa-duotone fa-eye"></i>
                    </button>
                  </a>

                  <form action="{{ route('restaurant.delete',$restaurant->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure?')">
                    @csrf

                    <input type="hidden" name="_method" value="DELETE"> <button type="submit"
                      class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700">
                      <i class="fa-duotone fa-trash"></i>
                    </button>
                  </form>

                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="11" class="text-center pt-5">
                No Item Found
              </td>
            </tr>
            @endforelse

          </tbody>

          @if ($restaurants->hasPages())
          <tfoot>
            <tr>
              <td colspan="10" >
                <div class="mt-10 px-4">
                  {!! $restaurants->links() !!}
                </div>
              </td>
            </tr>
          </tfoot>
          @endif

        </table>
      </div>
    </x-partials.card>

  </div>

@endsection