@extends('admin.layouts.app')
@section('content')



    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.restaurant_user.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('codes.index') }}" class="mr-4"
                        ><i class="fad fa-arrow-left"></i
                    ></a>
                </x-slot>

                <div class="mt-5">

                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.restaurant_user.inputs.photo')
                        </h5>
                        <x-partials.thumbnail
                            src="{{ $contact->photo ? \Storage::url($contact->photo) : '' }}"
                            size="150"
                        />
                    </div>

                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.restaurant_user.inputs.name')
                        </h5>
                        <span>{{ $contact->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.restaurant_user.inputs.bio')
                        </h5>
                        <span>{{ $contact->bio ?? '-' }}</span>
                    </div>

                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.restaurant_user.inputs.company')
                        </h5>
                        <span>{{ $contact->company ?? '-' }}</span>
                    </div>

                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.restaurant_user.inputs.designation')
                        </h5>
                        <span>{{ $contact->designation ?? '-' }}</span>
                    </div>

                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.restaurant_user.inputs.phone')
                        </h5>
                        <span>{{ $contact->phone ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.restaurant_user.inputs.address')
                        </h5>
                        <span>{{ $contact->address ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.restaurant_user.inputs.email')
                        </h5>
                        <span>{{ $contact->email ?? '-' }}</span>
                    </div>

                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.restaurant_user.inputs.is_verified')
                        </h5>
                        <span>{{ $contact->is_verified ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.restaurant_user.inputs.code_id')
                        </h5>
                        <span>{{ optional($contact->code)->code ?? '-' }}</span>
                    </div>
                </div>


                <div class="mt-10">
                    <a href="{{ route('restaurant_user.index') }}" class="px-4 py-3 mt-4 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 hover:text-gray-700 mr-1">
                        <i class="fa-duotone fa-arrow-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\RestaurantUser::class)
                    <a href="{{ route('restaurant_user.create') }}" class="px-4 py-3 mt-4 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 hover:text-gray-700 mr-1">
                        <i class="mr-1 fa-duotone fa-circle-plus"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>

@endsection
