@extends('admin.layouts.app')
@section('content')


  <div class="px-12 py-12">

    <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
      Catelog Lists
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
            @can('create', App\Models\catalogs::class)
            <a href="{{ route('catalog.create') }}"
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
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:text-gray-400 px-4 py-3">

            <tr class="bg-gray-50">
              <th class="px-4 py-3 " style="width: 50px;"> S/N </th>
              <th class="px-4 py-3 " style="width: 150px;"> Name </th>
              <th class="px-4 py-3 text-center" style="width: 130px;"> Status </th>
              <th class="px-4 py-3 " style="width: 190px;"> Restaurant </th>
              <th class="px-4 py-3 truncate" style="width: 50px;"> Display Order </th>
              <th class="px-4 py-3 truncate" style="width: 120px;">  Created At </th>
              <th class="px-4 py-3 " style="width: 150px;">Action</th>
            </tr>

          </thead>

          <tbody>

            @forelse ($catalogs as $catalog)
            <tr>
              <td class="px-4 py-3">{{ $catalog->serial_index }}</td>
              <td class="px-4 py-3">{{ $catalog->name }}</td>

              <td class="px-4 py-3 text-center truncate">
                                
                @if ($catalog->status == 1)
                <span ><i class="fa-sharp fa-solid fa-circle-check text-green-600"></i> Active</span>
                @else
                <span><i class="fa-sharp fa-solid fa-circle-xmark text-red-600"></i> InActive</span>
                @endif

              </td>

              <td class="px-4 py-3">{{ $catalog->restaurant_name }}</td>

              <td class="px-4 py-3">{{ $catalog->display_order }}</td>
              <td class="px-4 py-3">{{ $catalog->created_at->format('Y-m-d H:i:s') }}</td>

              <td class="px-4 py-3 " style="width: 134px;">
                <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle ">

                  <a href="{{ route('catalog.edit',$catalog->id) }}" class="mr-1">
                    <button type="button"
                      class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">
                      <i class="fa-duotone fa-pencil"></i>
                    </button>
                  </a>

                  <form action="{{ route('catalog.delete',$catalog->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                      class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700">

                      <i class="fa-duotone fa-trash"></i>

                    </button>
                  </form>

                </div>
              </td>

            </tr>
            @empty
                <tr><td colspan="8" class="text-center pt-5">No Data Found</td></tr>
            @endforelse

        
          </tbody>

          @if ($catalogs->hasPages())
          <tfoot>
            <tr>
              <td colspan="10">
                <div class="mt-10 px-4">
                  {!! $catalogs->links() !!}
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