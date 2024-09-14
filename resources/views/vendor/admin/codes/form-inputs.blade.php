@php $editing = isset($code) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="code"
            label="Code"
            :value="old('code', ($editing ? $code->code : ''))"
            maxlength="255"
            placeholder="Code"
            readonly
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="has_card"
            label="Has Card"
            :checked="old('has_card', ($editing ? $code->has_card : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>
</div>
