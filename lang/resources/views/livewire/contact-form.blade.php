


<div>
    @if($showModal)
    <div class="fixed z-[999] inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 backdrop-blur-sm bg-gray-500/30 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white/90 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        <i class="mr-1 fa-light fa-message-lines"></i>
                        Message
                    </h3>
                    <div class="mt-4">
                        <form wire:submit.prevent="submit">
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                                <input wire:model="name" type="text" id="name" class="w-full px-3 py-2 text-gray-700 bg-gray-100/50 rounded-md border border-stroke focus-visible:outline-none mb-1">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                                <input wire:model="email" type="email" id="email" class="w-full px-3 py-2 text-gray-700 bg-gray-100/50 rounded-md border border-stroke focus-visible:outline-none mb-1">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Message</label>
                                <textarea wire:model="message" id="message" rows="4" class="w-full px-3 py-2 text-gray-700 bg-gray-100/50 rounded-md border border-stroke focus-visible:outline-none"></textarea>
                                @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex items-center justify-between">
                                <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 mt-4 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 hover:text-gray-700 mr-1">
                                    <i class="mr-1 fa-light fa-arrow-left"></i>
                                    Back
                                </button>
                                <button type="submit" class="px-4 py-2 mt-4 text-white bg-meta-3/90 rounded-md hover:bg-meta-3 mt-5">
                                    <i class="mr-1 fa-light fa-paper-plane"></i>
                                    Send
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
