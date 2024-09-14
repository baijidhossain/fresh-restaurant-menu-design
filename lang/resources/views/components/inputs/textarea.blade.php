@props([
    'name',
    'label',
])

@if($label ?? null)
    @include('components.inputs.partials.label')
@endif

<textarea
    id="{{ $name }}"
    name="{{ $name }}"
    rows="3"
    {{ ($required ?? false) ? 'required' : '' }}
    {{ $attributes->merge(['class' => 'w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none']) }}
    autocomplete="off"
>{{$slot}}</textarea>

@error($name)
    @include('components.inputs.partials.error')
@enderror
