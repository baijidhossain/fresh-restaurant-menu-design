

    <ul class="menu-item-list list-unstyled">
        @forelse ($items as $item)

        <li class="list-item list-group-item px-0">
          <div class="list-item-content">

            <div class="item-image-box">
              <img class="item-image" data-fancybox="gallery"
                src="{{ $item->image ? \Storage::url($item->image ?? "") : \Storage::url('default/item-pleaceholder.png') }}"
                alt="{{ $item->name }} logo">

              @if ($item->offer_price > 0)
              <span class="offer-badge">Offer</span>
              @endif

            </div>

            <div class="item-details">

              <div class="d-flex justify-content-between align-items-baseline">
                <h5 class="item-title line-clamp2">{{ $item->name }}</h5>
                <div class="item-price text-nowrap">
                  ৳ {{ $item->price }}

                  @if ($item->offer_price > 0)
                  <span class="offer-price">
                    ৳ {{ $item->offer_price }}
                  </span>
                  @endif

                </div>
              </div>

              <p class="item-description line-clamp2"> {{ $item->description }} </p>
              <ul class="item-tags list-unstyled d-flex gap-2">
                <li class="text-nowrap">
                  @if ($item->popular == 1)
                  <small class="text_tomato me-2"><i class="ri-fire-line"></i> Popular</small>
                  @endif

                  @if ($item->custom_field)
                  <small class="text-body-secondary"><i class="ri-time-line"></i> {{ $item->custom_field }}</small>
                  @endif

                </li>

              </ul>
            </div>

          </div>
        </li>
       
        @empty
            <li class="list-item list-group-item text-center px-0 my-3">   
              <img  src="{{ \Storage::url('default/search-icon.svg') }}" width="36" height="36">
              <p class="my-1">No Data Found</p>
            </li>
        @endforelse

    </ul>

