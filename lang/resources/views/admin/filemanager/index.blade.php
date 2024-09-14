@extends('admin.layouts.app')
@section('content')
<div class="py-12">
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
            File Manager
        </h2>

       


            <div class="md:w-1/3">
            <x-partials.card>
                <ul class="list-disc">
                    @forelse($directories as $directory)
                    <li>{{ basename($directory) }}</li>
                    @empty
                    <li>No directories found.</li>
                    @endforelse
                </ul>
                </x-partials.card>
            </div>

       
    </div>
</div>
@endsection