@php $editing = isset($restaurant) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-1/2 pr-3">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $restaurant->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2 mx-4 ">
      <x-inputs.text
          name="phone"
          label="Phone"
          :value="old('phone', ($editing ? $restaurant->phone : ''))"
          maxlength="20"
          placeholder="Phone"
          required
      ></x-inputs.text>
  </x-inputs.group>

  <x-inputs.group class="w-full mx-4 ">
    <x-inputs.text
        name="address"
        label="Address"
        :value="old('address', ($editing ? $restaurant->address : ''))"
        maxlength="20"
        placeholder="Address"
        required
    ></x-inputs.text>
    
</x-inputs.group>

    {{-- <x-inputs.group class="w-full">
        <x-inputs.textarea name="bio" label="Bio" maxlength="255"
            >{{ old('bio', ($editing ? $restaurant_user->bio : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="designation"
            label="Designation"
            :value="old('designation', ($editing ? $restaurant_user->designation : ''))"
            maxlength="255"
            placeholder="Designation"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="company"
            label="Company"
            :value="old('company', ($editing ? $restaurant_user->company : ''))"
            maxlength="255"
            placeholder="Company"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="phone"
            label="Phone"
            :value="old('phone', ($editing ? $restaurant_user->phone : ''))"
            maxlength="255"
            placeholder="Phone"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="address"
            label="Address"
            :value="old('address', ($editing ? $restaurant_user->address : ''))"
            maxlength="255"
            placeholder="Address"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.email
            name="email"
            label="Email"
            :value="old('email', ($editing ? $restaurant_user->email : ''))"
            maxlength="255"
            placeholder="Email"
            required
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <div x-data="imageViewer('{{ $editing && $restaurant_user->photo ? \Storage::url($restaurant_user->photo) : '' }}')" >
          
            <x-inputs.partials.label
                name="photo"
                label="Photo"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="photo"
                    id="photo"
                    @change="fileChosen"
                />
            </div>

            @error('photo') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.password
            name="password"
            label="Password"
            maxlength="255"
            placeholder="Password"
            :required="!$editing"
        ></x-inputs.password>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="is_verified"
            label="Is Verified"
            :checked="old('is_verified', ($editing ? $restaurant_user->is_verified : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group> --}}

</div>

<div class="flex flex-wrap">

  <x-inputs.group class="w-1/2 pr-3">
    <div x-data="imageViewer('{{ $editing && $restaurant_user->photo ? \Storage::url($restaurant_user->photo) : '' }}')" >
      
        <x-inputs.partials.label
            name="logo"
            label="logo"
        ></x-inputs.partials.label
        ><br />
  
        <!-- Show the image -->
        <template x-if="imageUrl">
            <img
                :src="imageUrl"
                class="object-cover rounded border border-gray"
                style="width: 100px; height: 100px;"
            />
        </template>
  
        <!-- Show the gray box when image is not available -->
        <template x-if="!imageUrl">
            <div
                class="border rounded border-gray bg-gray-100"
                style="width: 100px; height: 100px;"
            ></div>
        </template>
  
        <div class="mt-2">
            <input
                type="file"
                name="logo"
                id="photo"
                @change="fileChosen"
            />
        </div>
  
        @error('photo') @include('components.inputs.partials.error')
        @enderror
    </div>
  </x-inputs.group>
  
  <x-inputs.group class="w-1/2">
    <div x-data="imageViewer('{{ $editing && $restaurant_user->photo ? \Storage::url($restaurant_user->photo) : '' }}')" >
      
        <x-inputs.partials.label
            name="banner"
            label="Banner"
        ></x-inputs.partials.label
        ><br />
  
        <!-- Show the image -->
        <template x-if="imageUrl">
            <img
                :src="imageUrl"
                class="object-cover rounded border border-gray"
                style="width: 100px; height: 100px;"
            />
        </template>
  
        <!-- Show the gray box when image is not available -->
        <template x-if="!imageUrl">
            <div
                class="border rounded border-gray bg-gray-100"
                style="width: 100px; height: 100px;"
            ></div>
        </template>
  
        <div class="mt-2">
            <input
                type="file"
                name="banner"
                id="photo"
                @change="fileChosen"
            />
        </div>
  
        @error('photo') @include('components.inputs.partials.error')
        @enderror
    </div>
  </x-inputs.group>
</div>
