@extends('admin.layouts.app')

@push('styles')
<style>
  .drop-area {
    border: 2px dashed #ccc;
    border-radius: 8px;
    width: 100%;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    font-size: 1em;
    color: #aaa;
    background-color: #f9f9f9;
    position: relative;
    transition: border-color 0.3s, background-color 0.3s;
    overflow: hidden;
  }

  .drop-area#drop-area-product {
    height: 114px !important;
  }

  .drop-area.dragover {
    border-color: #4a90e2;
    background-color: #e1f5fe;
  }

  #preview-logo {
    max-width: 100%;
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  #preview-banner {
    max-width: 100%;
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  #file-input-logo,
  #file-input-banner {
    display: none;
  }

  .upload_icon {
    font-size: 15px;
    color: #ccc;
    cursor: pointer;
    position: absolute;
    bottom: 10px;
    right: 10px;
    cursor: pointer;
  }

  .text-red-600 {
    color: #e53e3e;
  }

  .text-sm {
    font-size: 0.875rem;
  }
</style>
@endpush

@section('content')


  <div class="px-12 pt-12">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
      Restaurant Info
    </h2>

    <x-partials.card>
   
      <div class="block w-full overflow-auto scrolling-touch">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

          <tbody>

            <tr>
              <th>Name:</th>
              <td>{{ $restaurant->name }}</td>
              <th>Start Time:</th>
              <td>{{ date_create($restaurant->start_time)->format('g:i A')  }}</td>
              <th>End Time:</th>
              <td>{{ date_create($restaurant->end_time)->format('g:i A')  }}</td>
            </tr>

            <tr>
              <th>Logo:</th>
              <td class=" py-3"><img src="{{ $restaurant->logo ? \Storage::url("restaurant/logos/".$restaurant->logo) : '' }}"
                  alt="{{ $restaurant->name }} logo" style="width: 50px; height: auto;"></td>

              <th>Banner:</th>
              <td class=" py-3"><img src="{{ $restaurant->logo ? \Storage::url("restaurant/banners/".$restaurant->banner) : '' }}"
                  alt="{{ $restaurant->name }} logo" style="width: 10%; height: auto;"></td>
            </tr>

          </tbody>

        </table>
      </div>

    </x-partials.card>
  </div>

  <div class="px-12 py-6">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
      Catalog List
    </h2>

    <x-partials.card>

      <div class="mb-6">
        <div class="flex flex-wrap justify-end">
          <div class="md:w-1/2 text-right">
            @can('create', App\Models\catalog::class)
            <a href="{{ route('restaurant.create') }}"
              class="rounded bg-primary px-6 py-3 font-medium hover:bg-opacity-90 text-white">
              <i class="mr-1 fa-duotone fa-circle-plus"></i>
              @lang('crud.common.create')
            </a>
            @endcan
          </div>
        </div>
      </div>
    
      <div class="block w-full overflow-auto scrolling-touch">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:text-gray-400 px-4 py-3">

            <tr class="bg-gray-50">
              <th class="px-4 py-3 " style="width: 300px;"> Name </th>
              <th class="px-4 py-3 text-center" style="width: 150px;"> Status </th>
              <th class="px-4 py-3 truncate" style="width: 150px;"> Display Order </th>
              <th class="px-4 py-3 " style="width: 90px;">Action</th>
            </tr>

          </thead>

          <tbody>

            @forelse ($catalogs as $catalog)
            <tr>

              <td class="px-4 py-3">{{ $catalog->name }}</td>

              <td class="px-4 py-3 text-center truncate">

                @if ($catalog->status == 1)
                <span><i class="fa-sharp fa-solid fa-circle-check text-green-600"></i> Active</span>
                @else
                <span><i class="fa-sharp fa-solid fa-circle-xmark text-red-600"></i> InActive</span>
                @endif

              </td>

              <td class="px-4 py-3">{{ $catalog->display_order }}</td>

              <td class="px-4 py-3 " style="width: 134px;">
                <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle ">

                  <a href="{{ route('catalog.edit',$catalog->id) }}" class="mr-1">
                    <button type="button"
                      class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">
                      <i class="fa-duotone fa-pencil"></i>
                    </button>
                  </a>

                  <form action="{{ route('catalog.delete',$catalog->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                      class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700">

                      <i class="fa-duotone fa-trash"></i>

                    </button>
                  </form>

                </div>
              </td>

            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center pt-5">No Data Found</td>
            </tr>
            @endforelse

          </tbody>

          @if ($catalogs->hasPages())
          <tfoot>
            <tr>
              <td colspan="5">
                <div class="mt-10 px-4">
                  {!! $catalogs->links() !!}
                </div>
              </td>
            </tr>
          </tfoot>
          @endif

        </table>
      </div>

    </x-partials.card>
  </div>

  <div class="px-12 py-6">

    <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
      Menu Lists
    </h2>

    <x-partials.card>

      <div class="mb-6">
        <div class="flex flex-wrap justify-end">
          <div class="md:w-1/2 text-right">
            @can('create', App\Models\catalog_item::class)
            <a href="{{ route('restaurant.create') }}"
              class="rounded bg-primary px-6 py-3 font-medium hover:bg-opacity-90 text-white">
              <i class="mr-1 fa-duotone fa-circle-plus"></i>
              @lang('crud.common.create')
            </a>
            @endcan
          </div>
        </div>
      </div>

      <div class="block w-full overflow-auto scrolling-touch">

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:text-gray-400 px-4 py-3">

            <tr class="bg-gray-50">

              <th class="x-4 py-3 "  style="width: 50px;">S/N</th>
              <th class="px-4 py-3 " style="width: 100px;"> Image </th>
              <th class="px-4 py-3 " style="width: 170px;"> Catalog Name </th>
              <th class="px-4 py-3 " style="width: 170px;"> Item Name </th>
              <th class="px-4 py-3 " style="width: 250px;"> Description </th>
              <th class="px-4 py-3 " style="width: 100px;"> Price </th>
              <th class="px-4 py-3 " style="width: 100px;"> Offer Price </th>
              <th class="px-4 py-3 text-center" style="width: 50px;"> Popular </th>
              <th class="px-4 py-3 text-center" style="width: 50px;"> Status </th>
              <th class="px-4 py-3 text-center" style="width: 125px;"> Display Order </th>
              <th class="px-4 py-3 text-center" style="width: 100px;"> Created At </th>
              <th class="px-4 py-3 " style="width: 100px;">Action</th>
            </tr>

          </thead>

          <tbody>

            @forelse ($catalog_items as $item)

            <tr>

              <td class="px-4 py-3">{{ $item->serial_index }}</td>

              <td class="px-4 py-3">
                <img class="rounded" src="{{ $item->image ? \Storage::url("restaurant/products/thumbnails/".$item->image ?? "") : \Storage::url('default/item-pleaceholder.png') }}" alt="{{ $item->name }} logo" style="width: 50px; height: auto;">
              </td>
              <td class="px-4 py-3">{{ $item->catalog_name }}</td>
              <td class="px-4 py-3">{{ $item->name }}</td>
              <td class="px-4 py-3">{{ $item->description }}</td>
              <td class="px-4 py-3">{{ $item->price }}</td>
              <td class="px-4 py-3">{{ $item->offer_price }}</td>
              <td class="px-4 py-3 text-center">

                @if ($item->popular == 1)
                <span><i class="fa-sharp fa-solid fa-circle-check text-green-600"></i> </span>
                @else
                <span><i class="fa-sharp fa-solid fa-circle-xmark text-red-600"></i></span>
                @endif

              </td>

              <td class="px-4 py-3 text-center truncate">

                @if ($item->status == 1)
                <span><i class="fa-sharp fa-solid fa-circle-check text-green-600"></i> Active</span>
                @else
                <span><i class="fa-sharp fa-solid fa-circle-xmark text-red-600"></i> InActive</span>
                @endif

              </td>

              <td class="px-4 py-3 text-center">{{ $item->display_order }}</td>

              <td class="px-4 py-3 text-center">  {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i:s') }} </td>

              <td class="px-4 py-3 " style="width: 134px;">
                <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle ">

                  <a href="{{ route('catalog.item.edit',$item->id) }}" class="mr-1">
                    <button type="button"
                      class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">
                      <i class="fa-duotone fa-pencil"></i>
                    </button>
                  </a>

                  <form action="{{ route('catalog.item.delete',$item->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure want to delete this item?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                      class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700">

                      <i class="fa-duotone fa-trash"></i>

                    </button>
                  </form>

                </div>
              </td>

            </tr>

            @empty
            <tr>
              <td colspan="11" class="text-center pt-5">No Data Found</td>
            </tr>
            @endforelse

          </tbody>

          @if ($catalog_items->hasPages())
          <tfoot>
            <tr>
              <td colspan="15">
                <div class="mt-10 px-4">
                  {!! $catalog_items->links() !!}
                </div>
              </td>
            </tr>
          </tfoot>
          @endif

        </table>
      </div>
    </x-partials.card>

  </div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
  // Image preview and drag & drop handling
  function setupDropArea(dropAreaId, fileInputId, previewId, iconId) {
    var $dropArea = $('#' + dropAreaId);
    var $fileInput = $('#' + fileInputId);
    var $preview = $('#' + previewId);
    var $icon = $('#' + iconId);

    function handleFile(files) {
      if (files.length > 0) {
        var file = files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
          $preview.attr('src', e.target.result).show();
        };
        reader.readAsDataURL(file);
      }
    }
    $dropArea.on('dragover', function(event) {
      event.preventDefault();
      $(this).addClass('dragover');
    });
    $dropArea.on('dragleave', function() {
      $(this).removeClass('dragover');
    });
    $dropArea.on('drop', function(event) {
      event.preventDefault();
      $(this).removeClass('dragover');
      var files = event.originalEvent.dataTransfer.files;
      handleFile(files);
      $fileInput[0].files = files; // Update the hidden file input with the dropped files
    });
    $fileInput.on('change', function() {
      var files = $(this)[0].files;
      handleFile(files);
    });
    // Make the icon trigger the file input click event
    $icon.on('click', function() {
      $fileInput.click();
    });
  }
  // Initialize drop areas
  $(document).ready(function() {
    setupDropArea('drop-area-logo', 'file-input-logo', 'preview-logo', 'icon-logo');
    setupDropArea('drop-area-banner', 'file-input-banner', 'preview-banner', 'icon-banner');
    setupDropArea('drop-area-product', 'file-input-product', 'preview-product', 'icon-product');
  });
</script>
@endpush