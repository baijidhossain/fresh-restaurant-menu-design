<div class="row">

  @if(!empty($catalogFiles))
  @foreach($catalogFiles as $file)
  <div class="col-6 col-sm-4">
    <img class="thumbnail rounded-2 my-2" src="{{ Storage::url($file) }}" alt="Image"
      style="max-width: 100%; height: auto;">
  </div>
  @endforeach
  @else
  <p>No images found in the directory.</p>
  @endif

</div>
