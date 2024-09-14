<div>
    <div wire:sortable="updateLinkOrder">
        @foreach($socialLinks as $index => $link)
            <div wire:sortable.item="{{ $index }}" wire:key="link-{{ $index }}" class="flex items-center mb-4">

                <div class="mr-4">
                    <select
                        class="px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                        wire:model="socialLinks.{{ $index }}.key"
                        required
                        name="key[{{ $index }}]"
                    >
                        <option value="">Select</option>
                        @foreach($buttons as $key => $value)
                            <option value="{{ $key }}">{{ ucfirst($key) }}</option>
                        @endforeach
                    </select>
                </div>
                <input
                    type="url"
                    class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                    placeholder="URL"
                    wire:model="socialLinks.{{ $index }}.value"
                    required
                    name="value[{{ $index }}]"
                >
                <button
                    type="button"
                    class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 rounded ml-4"
                    wire:click="removeLink({{ $index }})"
                >
                    <i class="fa-light fa-trash"></i>
                </button>

                <div wire:sortable.handle class="ml-4 cursor-move">
                    <i class="fa-light fa-bars"></i>
                </div>
            </div>
        @endforeach
    </div>

    <button
        type="button"
        class="px-4 py-2 text-gray-600 bg-gray-200/90 rounded-md hover:bg-gray-200 w-full"
        wire:click="addLink"
    >
        <i class="mr-1 fa-light fa-circle-plus"></i> Add Link
    </button>
</div>

@push('scripts')
<script>
   document.addEventListener('livewire:load', function () {
    initSocialLinksSortable();
});

function initSocialLinksSortable() {
    var el = document.querySelector('[wire\\:sortable="updateLinkOrder"]');
    if (el) {
        Sortable.create(el, {
            animation: 150,
            handle: '[wire\\:sortable\\.handle]',
            draggable: '[wire\\:sortable\\.item]',
            onEnd: function (evt) {
                var itemEl = evt.item;
                var newIndex = evt.newIndex;
                var oldIndex = evt.oldIndex;
                Livewire.emit('updateLinkOrder',
                    Array.from(el.children).map(function (child, index) {
                        return {
                            svalue: child.getAttribute('wire:sortable.item'),
                            sorder: index
                        };
                    })
                );
            }
        });
    }
}
</script>
@endpush
