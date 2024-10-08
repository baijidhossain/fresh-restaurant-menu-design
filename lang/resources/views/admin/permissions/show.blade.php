@extends('admin.layouts.app')
@section('content')


    <div class="py-12">
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
                @lang('crud.permissions.show_title')
            </h2>


            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('permissions.index') }}" class="mr-4"
                        ><i class="fad fa-arrow-left"></i
                    ></a>
                </x-slot>

                <div class="mt-5">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.permissions.inputs.name')
                        </h5>
                        <span>{{ $permission->name ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('permissions.index') }}" class="px-4 py-3 mt-4 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 hover:text-gray-700 mr-1">
                        <i class="fa-duotone fa-arrow-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Permission::class)
                    <a href="{{ route('permissions.create') }}" class="px-4 py-3 mt-4 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 hover:text-gray-700 mr-1">
                        <i class="mr-1 fa-duotone fa-circle-plus"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
@endsection
