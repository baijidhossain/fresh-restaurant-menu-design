@if ($action == "new-folder")
<form action="{{ route('filemanager.createfolder') }}" method="POST" class="space-y-4 mb-0">
  @csrf
  <div>
    <label for="name" class="block text-sm font-medium text-gray-700">Folder Name</label>
    <input type="text" id="name" name="name" placeholder="Enter folder name"
      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
  </div>

  <!-- Button Container -->
  <div class="flex gap-4">
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Submit</button>
  </div>
</form>
@endif

@if ($action == "rename-folder")
<!-- Rename Folder Form -->
<form action="{{ route('filemanager.rename-folder') }}" method="POST" class="space-y-4 mb-0">
  @csrf

  <!-- Hidden field to store old folder name -->
  <input type="hidden" id="old_name" name="old_name" value="{{ $oldFolderName ?? '' }}" required />

  <div class="mb-4">
    <label for="new_name" class="block text-sm font-medium text-gray-700">Rename</label>
    <input type="text" id="new_name" name="new_name" value="{{ $oldFolderName ?? '' }}" placeholder="Enter new folder name"
      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
      required />
  </div>

  <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
    Submit
  </button>
</form>
@endif

