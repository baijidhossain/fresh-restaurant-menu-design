@props([
    'src',
    'size' => 50,
])

@if($src)
<img src="{{ $src }}" class="object-cover rounded border border-gray" style="width: {{ $size }}px; height: {{ $size }}px;">
@else
<div class="border rounded border-gray bg-gray-100" style="width: {{ $size }}px; height: {{ $size }}px;"></div>
@endif
