@extends('admin.layouts.app')
@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
                {{-- @lang('crud.restaurant_user.index_title') --}}
                Restaurant User Lists
            </h2>

            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text name="search" value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }}" autocomplete="off"></x-inputs.text>

                                    <div class="ml-1">
                                        <button type="submit"
                                            class="rounded bg-primary px-6 py-3 font-medium hover:bg-opacity-90 text-white">
                                            <i class="fa-duotone fa-magnifying-glass"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            @can('create', App\Models\RestaurantUser::class)
                                <a href="{{ route('restaurant_user.create') }}"
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
                             <th class="px-4 py-3 text-left" style="width: 50px;"> S/N </th>
                             <th class="px-4 py-3 text-left" style=" width: 100px; "> Photo </th>
                             <th class="px-4 py-3 text-left" style=" width: 150px; "> Name </th>
                             <th class="px-4 py-3 text-left" style="width: 170px;"> Phone </th>
                             <th class="px-4 py-3 text-left" style="width: 100px;"> Email </th>
                             <th class="px-4 py-3 text-left" style="width: 50px;"> Verified </th>
                             <th class="px-4 py-3 text-left" style="width: 300px;"> Code </th>
                             <th class="px-4 py-3 text-left"> Created At </th>
                             <th class="px-4 py-3 text-right" style="width: 80px;"> Action </th>
                          </tr>
                       </thead>

                        <tbody class="text-gray-600">
                            @forelse($restaurant_user as $contact)
                                <tr
                                    class="hover:bg-gray-50 {{ $loop->index % 2 == 0 ? '' : 'bg-gray-50' }} {{ $loop->last ? '' : 'border-b border-stroke' }}">

                                    <td class="px-4 py-3 text-left">{{ $contact->serial_index }}</td>

                                    <td class="px-4 py-3 text-left">
                                        <x-partials.thumbnail
                                            src="{{ $contact->photo ? \Storage::url($contact->photo) : '' }}" />
                                    </td>

                                    <td class="px-4 py-3 text-left">
                                        {{ $contact->name ?? '-' }}
                                    </td>


                                    <td class="px-4 py-3 text-left">
                                        {{ $contact->phone ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $contact->email ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-left">
                                        <i
                                            class="{{ $contact->is_verified ? 'fa-duotone fa-check-circle text-green-500' : 'fa-duotone fa-times-circle text-red-500' }}"></i>
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        {{ optional($contact->code)->code ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-left">
                                      {{ $contact->created_at->format('Y-m-d H:i:s') }}
                                  </td>

                                    <td class="px-4 py-3 text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions"
                                            class="
                                            relative
                                            inline-flex
                                            align-middle
                                        ">
                                            @can('update', $contact)
                                                <a href="{{ route('restaurant_user.edit', $contact) }}" class="mr-1 pb-0">
                                                    <button type="button"
                                                        class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">
                                                        <i class="fa-duotone fa-pencil"></i>
                                                    </button>
                                                </a>
                                                @endcan

                                                @can('delete', $contact)
                                                <form action="{{ route('restaurant_user.destroy', $contact) }}" method="POST"
                                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700">
                                                        <i class="fa-duotone fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="pt-5 text-center">
                                       No Data Found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        @if ($restaurant_user->hasPages())
                        <tfoot>
                          <tr>
                            <td colspan="10">
                              <div class="mt-10 px-4">
                                {!! $restaurant_user->links() !!}
                              </div>
                            </td>
                          </tr>
                        </tfoot>
                        @endif

                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
@endsection
