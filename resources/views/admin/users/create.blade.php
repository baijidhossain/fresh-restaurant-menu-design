@extends('admin.layouts.app')
@section('content')

    <div class="py-12">
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
                @lang('crud.users.create_title')
            </h2>


            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('users.index') }}" class="mr-4"
                        ><i class="fad fa-arrow-left"></i
                    ></a>
                </x-slot>

                <x-form
                    method="POST"
                    action="{{ route('users.store') }}"
                    class="mt-4"
                >
                    @include('admin.users.form-inputs')

                    <div class="mt-10">
                        <a href="{{ route('users.index') }}" class="px-4 py-3 mt-4 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 hover:text-gray-700 mr-1">
                            <i
                                class="fa-duotone fa-arrow-left"
                            ></i>
                            @lang('crud.common.back')
                        </a>

                        <button
                            type="submit"
                            class="rounded bg-primary px-6 py-3 font-medium hover:bg-opacity-90 text-white float-right"
                        >
                            <i class="mr-1 fa-duotone fa-floppy-disk"></i>
                            @lang('crud.common.create')
                        </button>
                    </div>
                </x-form>
            </x-partials.card>
        </div>
    </div>
@endsection
