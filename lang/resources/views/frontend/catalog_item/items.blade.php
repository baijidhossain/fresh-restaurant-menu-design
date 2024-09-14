<div class="row">

  @if(!empty($catalogFiles))
  @foreach($catalogFiles as $file)
  <div class="col-6 col-sm-4 col-lg-3">
    <div class="thumbnail">
    <img src="{{ Storage::url($file) }}" alt="Image">
    </div>
  </div>
  @endforeach
  @else
  <p>No images found in the directory.</p>
  @endif

</div>
