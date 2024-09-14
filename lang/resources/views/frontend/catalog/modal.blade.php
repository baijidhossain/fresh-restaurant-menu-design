@if ($action == "add")

<form action="{{ route('account.catalog.store') }}" method="POST">
  @csrf
  <div class="modal-header">

    <h5 class="modal-title" id="exampleModalLabel">{{ $modal_title }}</h5>

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

    </button>

  </div>

  <div class="modal-body">

    <div class="mb-3">
      <label for="name" class="form-label required-star">Name <span class="required-indicator">*</span></label>
      <input type="text" class="form-control" id="name" maxlength="80" name="name" placeholder="Ex: Pizza" required>
    </div>

    <div class="row">

      <div class="col-md-6">

        <div class="mb-3">

          <label for="status" class="form-lable required-star">Status <span class="required-indicator">*</span></label>
          <select class="form-select" aria-label="status" name="status" required id="status">
            <option selected value="1">Active</option>
            <option value="0">inActive</option>
          </select>

        </div>

      </div>

      <div class="col-md-6">

        <div class=" form-group mb-3">

          <label for="display_order" class="form-lable ">Display Order </label>
          <input type="number" class="form-control" id="display_order" name="display_order" placeholder="Ex: 0" >

        </div>

      </div>

    </div>

  </div>

  <div class="modal-footer catalog-footer">
    <button type="button" class="btn btn-outline-primary  float-end px-3 btn-cancel" data-bs-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-primary  float-end px-3 btn-save">Save</button>
  </div>

</form>
@endif

@if ($action == "edit")
<form action="{{ route('account.catalog.update', $catalog->id) }}" method="POST">
  @csrf
  @method('PUT')
  <!-- Ensure the form uses the PUT method for updates -->

  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ $modal_title }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>

  <div class="modal-body">

    <div class="mb-3">

      <label for="name" class="form-label required-star">Name <span class="required-indicator">*</span></label>
      <input type="text" class="form-control" id="name" name="name" maxlength="80" placeholder="Ex: Pizza" value="{{ old('name', $catalog->name) }}" required>

      @error('name')
      <div class="text-danger">{{ $message }}</div>
      @enderror

    </div>

    <div class="row">
      <div class="col-md-6">

        <div class="mb-3">
          <label for="status" class="form-label required-star">Status <span class="required-indicator">*</span></label>
          <select class="form-select" aria-label="status" name="status" id="status" required>
            <option value="1" {{ old('status', $catalog->status) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status', $catalog->status) == 0 ? 'selected' : '' }}>Inactive</option>
          </select>
          @error('status')
          <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

      </div>

      <div class="col-md-6">

        <div class="mb-3">

          <label for="display_order" class="form-label ">Display Order </label>
          <input type="number" class="form-control" id="display_order" name="display_order" placeholder="Ex: 0" value="{{ old('display_order', $catalog->display_order) }}" >

          @error('display_order')
          <div class="text-danger">{{ $message }}</div>
          @enderror

        </div>

      </div>
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-outline-primary  float-end px-3" data-bs-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-primary  float-end px-3">Update</button>
  </div>

</form>
@endif