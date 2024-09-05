

@if ($errors->any())
    @foreach ($errors->all() as $error)

        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
          <strong title="Error"> <i class="ri-error-warning-line"></i> </strong>  {{ $error }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    @endforeach
@endif
