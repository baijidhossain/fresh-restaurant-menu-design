@extends('admin.layouts.app')
@section('content')
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
                {{ __('API Tokens') }}
            </h2>
            @livewire('api.api-token-manager')
        </div>
    </div>
@endsection
