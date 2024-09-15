<aside :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full'"
    class="absolute left-0 top-0 z-9999 flex h-screen w-72.5 flex-col overflow-y-hidden bg-black duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0"
    @click.outside="sidebarToggle = false">
    <!-- SIDEBAR HEADER -->
    <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5">
        <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-white">
      
        <img src="{{ \Storage::url('gocards.svg') }}" alt="" width="170"  >

        </a>

        <button class="block lg:hidden" @click.stop="sidebarToggle = !sidebarToggle">
            <svg class="fill-current" width="20" height="18" viewBox="0 0 20 18" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z"
                    fill="" />
            </svg>
        </button>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
        <!-- Sidebar Menu -->
        <nav class="mt-5 px-4 py-4 lg:mt-9 lg:px-6">
            <!-- Menu Group -->
            <div>
                <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">MENU</h3>

                <ul class="mb-6 flex flex-col gap-1.5">


                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{request()->is('admin') ? 'bg-graydark' : ''}}"
                            href="{{ route('dashboard') }}">
                            <i class="fa-duotone fa-grid-2"></i>
                            Dashboard
                        </a>
                    </li>


                    @can('view-any', App\Models\Code::class)
                        <li>
                            <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{request()->is('admin/codes*') ? 'bg-graydark' : ''}}"
                                href="{{ route('codes.index') }}">
                                <i class="fa-duotone fa-list-ol"></i>
                                Codes
                            </a>
                        </li>
                    @endcan

                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{request()->is('admin/qr*') ? 'bg-graydark' : ''}}"
                            href="{{ route('qr.generator') }}">
                            <i class="fa-duotone fa-qrcode"></i>
                             QR Generator
                        </a>
                    </li>


                </ul>
            </div>

            <div>
              <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">Restaurant</h3>
              <ul class="mb-6 flex flex-col gap-1.5">

                @can('view-any', App\Models\Restaurant::class)
                <li>
                  <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{request()->is('admin/restaurant') ? 'bg-graydark' : ''}}"
                    href="{{ route('restaurant.index') }}">
                    <i class="fa-duotone  fa-fork-knife"></i> Restaurants
                  </a>
                </li>
                @endcan

                @can('view-any', App\Models\RestaurantUser::class)
                <li>
                  <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{request()->is('admin/restaurant_user*') ? 'bg-graydark' : ''}}"
                    href="{{ route('restaurant_user.index') }}">
                    <i class="fa-duotone fa-address-book"></i>Restaurant Users
                  </a>
                </li>
                @endcan

                @can('view-any', App\Models\Catalog::class)

                <li>
                  <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{request()->is('admin/catalog') ? 'bg-graydark' : ''}}"
                    href="{{ route('catalog.index') }}">
                    <i class="fa-duotone  fa-list"></i> Catalogs
                  </a>
                </li>

                @endcan

                @can('view-any', App\Models\CatalogItem::class)

                <li>
                  <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{request()->is('admin/catalog_item*') ? 'bg-graydark' : ''}}"
                    href="{{ route('catalog.item.index') }}">
                    <i class="fa-duotone  fa-list-tree"></i> Catalog Items
                  </a>
                </li>

                @endcan


                @can('view-any', App\Models\FileManager::class)

                <li>
                  <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{request()->is('admin/filemanager*') ? 'bg-graydark' : ''}}"
                    href="{{ route('filemanager.index') }}">
                    <i class="fa-duotone  fa-files"></i> FileManager
                  </a>
                </li>

                @endcan

              </ul>
            </div>

            @if (Auth::user()->can('view-any', Spatie\Permission\Models\Role::class) ||
                    Auth::user()->can('view-any', Spatie\Permission\Models\Permission::class || Auth::user()->can('view-any', App\Models\User::class)))
                <div>

                    <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">OTHERS</h3>

                    <ul class="mb-6 flex flex-col gap-1.5">
                        <!-- Menu Item Dashboard -->


                        <li>
                            <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{request()->is('admin/backups*') ? 'bg-graydark' : ''}}"
                                href="{{ route('backups.index') }}">
                                <i class="fa-duotone fa-cloud-check"></i>
                                Backups
                            </a>
                        </li>


                        @can('view-any', App\Models\User::class)
                        <li>
                            <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{request()->is('admin/users*') ? 'bg-graydark' : ''}}"
                                href="{{ route('users.index') }}">
                                <i class="fa-duotone fa-user-group-crown"></i> Users
                            </a>
                        </li>
                        @endcan


                        @can('view-any', Spatie\Permission\Models\Role::class)
                            <li>
                                <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{request()->is('admin/roles*') ? 'bg-graydark' : ''}}"
                                    href="{{ route('roles.index') }}">
                                    <i class="fa-duotone fa-user-crown"></i> Roles
                                </a>
                            </li>
                        @endcan

                        @can('view-any', Spatie\Permission\Models\Permission::class)
                            <li>
                                <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4 {{request()->is('admin/permissions*') ? 'bg-graydark' : ''}}"
                                    href="{{ route('permissions.index') }}">
                                    <i class="fa-duotone fa-key"></i> Permissions
                                </a>
                            </li>
                        @endcan



                    </ul>

                </div>
            @endif

        </nav>
        <!-- Sidebar Menu -->


    </div>
</aside>
