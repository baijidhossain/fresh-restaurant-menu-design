<div>
    <div wire:sortable="updateNoteOrder">
        @foreach($notes as $index => $note)
            <div wire:sortable.item="{{ $index }}" wire:key="note-{{ $index }}" class="flex items-center mb-4">
                <div class="mr-4">
                    <input
                        type="text"
                        wire:model="notes.{{ $index }}.property"
                        name="property[{{ $index }}]"
                        placeholder="Enter a key"
                        class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                        required
                    >
                </div>
                <input
                    type="text"
                    class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none"
                    placeholder="Enter a value"
                    wire:model="notes.{{ $index }}.asset"
                    required
                    name="asset[{{ $index }}]"
                >
                <button
                    type="button"
                    class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 rounded ml-4"
                    wire:click="removeNote({{ $index }})"
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
        wire:click="addNote"
    >
        <i class="mr-1 fa-light fa-circle-plus"></i> Add Another Filed
    </button>
</div>

@push('scripts')
<script>
   document.addEventListener('livewire:load', function () {
    initNotesSortable();
});

function initNotesSortable() {
    var el = document.querySelector('[wire\\:sortable="updateNoteOrder"]');
    if (el) {
        Sortable.create(el, {
            animation: 150,
            handle: '[wire\\:sortable\\.handle]',
            draggable: '[wire\\:sortable\\.item]',
            onEnd: function (evt) {
                var itemEl = evt.item;
                var newIndex = evt.newIndex;
                var oldIndex = evt.oldIndex;
                Livewire.emit('updateNoteOrder',
                    Array.from(el.children).map(function (child, index) {
                        return {
                            asset: child.getAttribute('wire:sortable.item'),
                            norder: index
                        };
                    })
                );
            }
        });
    }
}
</script>
@endpush
