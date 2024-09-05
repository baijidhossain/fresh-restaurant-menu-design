<aside :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full'"
    class="absolute left-0 top-0 z-9999 flex h-screen w-72.5 flex-col overflow-y-hidden bg-black duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0"
    @click.outside="sidebarToggle = false">
    <!-- SIDEBAR HEADER -->
    <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5">
        <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-white">
            <svg class="svg-twitter-avatar" viewBox="65 200.61 420 68.78" xmlns="http://www.w3.org/2000/svg"
            width="150px" height="40px" class="text-white">

            <g class="fill-current text-meta-3" fill-rule="nonzero">
                <g>
                    <g>
                        <path
                            d="M96.13306,269.23719c1.07906,0.10195 2.15756,0.15235 3.2349,0.15235c6.74415,0 13.39265,-1.98115 19.00905,-5.70919c1.90784,-1.26865 3.69997,-2.73604 5.32602,-4.36208c0.01317,-0.01317 0.02062,-0.0315 0.02062,-0.0504v-24.26749c0,-0.03952 -0.03207,-0.0716 -0.0716,-0.0716h-13.72313c-0.03952,0 -0.0716,0.03207 -0.0716,0.0716v17.65163c-8.06549,4.79107 -18.33091,3.5018 -24.97483,-3.14326c-8.00077,-8.0002 -8.00077,-21.01712 0,-29.01732c3.87581,-3.87581 9.02828,-6.00988 14.50837,-6.00988c5.48009,0 10.63256,2.13465 14.50837,6.00988c0.02692,0.02692 0.07503,0.02692 0.10195,0l9.70184,-9.70241c0.02749,-0.02806 0.02749,-0.07331 0,-0.10138c-6.49214,-6.495 -15.12694,-10.07184 -24.31216,-10.07184c-9.18579,0 -17.82174,3.57741 -24.31732,10.07241c-6.49615,6.49271 -10.07356,15.12752 -10.07356,24.31331c0,9.18579 3.57741,17.82174 10.07298,24.31732c5.64561,5.64561 13.12518,9.16803 21.06008,9.91834z" "/>
                            <path
                                d=" M153.00991,255.58918c11.37178,0 20.59042,-9.21865
                            20.59042,-20.59042c0,-11.37178 -9.21865,-20.59042
                            -20.59042,-20.59042c-11.37178,0 -20.59042,9.21865 -20.59042,20.59042c0,11.37178
                            9.21865,20.59042 20.59042,20.59042zM236.25248,249.51285c-0.02806,-0.02692
                            -0.07331,-0.02692 -0.10138,0c-8.0002,8.00077 -21.01712,8.00077
                            -29.01732,0c-8.0002,-8.0002 -8.0002,-21.01655 0,-29.01674c8.0002,-8.00077
                            21.01712,-8.00077 29.01732,0c0.02692,0.02749 0.07446,0.02692
                            0.10138,-0.00057l9.70241,-9.70814c0.02806,-0.02806 0.02806,-0.07331
                            0,-0.10138c-6.495,-6.495 -15.12981,-10.07241
                            -24.31216,-10.07241h-68.63283c-0.03952,0 -0.0716,0.03207
                            -0.0716,0.0716c0,0.03952 0.03207,0.0716 0.0716,0.0716c18.88133,0
                            34.24196,15.36063 34.24196,34.24196v0.00573c0,9.18235 3.57741,17.81658
                            10.07241,24.31216c6.49558,6.49558 15.13153,10.07298 24.31789,10.07298c9.18636,0
                            17.82002,-3.57741 24.31273,-10.07356c0.02806,-0.02806 0.02806,-0.07331
                            0,-0.10138z" />
                        <path
                            d="M257.20988,246.26391h14.88009c0.02291,0 0.04467,-0.01088 0.05785,-0.02921c0.01317,-0.01833 0.01718,-0.04238 0.01031,-0.06415l-7.44004,-23.12198c-0.0189,-0.05957 -0.11741,-0.05957 -0.13631,0l-7.44004,23.12198c-0.00687,0.02176 -0.00286,0.04582 0.01031,0.06415c0.01317,0.01833 0.03494,0.02921 0.05785,0.02921zM276.50588,259.84958h-23.71192c-0.03093,0 -0.05899,0.02005 -0.06816,0.04983l-3.02413,9.39313c-0.00687,0.02176 -0.00286,0.04582 0.01031,0.06415c0.01317,0.01833 0.03494,0.02921 0.05785,0.02921h29.76017c0.02291,0 0.04467,-0.01088 0.05785,-0.02921c0.01317,-0.01833 0.01718,-0.04238 0.01031,-0.06415l-3.02413,-9.39313c-0.00916,-0.02978 -0.03666,-0.04983 -0.06816,-0.04983zM340.58247,249.86538c7.52252,-4.9921 12.01289,-13.3537 12.01289,-22.38485c0,-14.81651 -12.05413,-26.87064 -26.87064,-26.87064h-53.86729c-0.02291,0 -0.04467,0.01088 -0.05785,0.02921c-0.01317,0.01833 -0.01718,0.04238 -0.01031,0.06415l22.0853,68.63283c0.00115,0.00344 0.00687,0.00286 0.00802,0.00573c0.01146,0.02405 0.0315,0.04353 0.06014,0.04353h13.72313c0.03952,0 0.0716,-0.03207 0.0716,-0.0716v-14.96256h17.98726c0.4393,0 0.87975,-0.01203 1.31275,-0.03322l9.2969,15.03416c0.01317,0.02119 0.03608,0.03379 0.06071,0.03379h16.12868c0.02577,0 0.04983,-0.01375 0.06243,-0.03666c0.0126,-0.02291 0.01203,-0.0504 -0.00172,-0.07274zM333.2209,238.10393c-2.18906,1.55731 -4.78133,2.38093 -7.49617,2.38093h-17.98726v-26.00865h17.98726c7.17085,0 13.00433,5.83405 13.00433,13.00433c0.00057,4.21717 -2.05904,8.18806 -5.50815,10.6234z" />
                        <path
                            d="M361.35581,269.38954h24.2652c18.96152,0 34.38858,-15.42649 34.38858,-34.38801c0,-18.96152 -15.42707,-34.38801 -34.38858,-34.38801h-24.2652c-0.03952,0 -0.0716,0.03207 -0.0716,0.0716v68.63283c0,0.03952 0.0315,0.0716 0.07159,0.0716zM375.14882,214.48328h10.47219c11.31414,0 20.51825,9.20469 20.51825,20.51825c0,11.31356 -9.20412,20.51825 -20.51825,20.51825h-10.47219z" />
                        <path
                            d="M464.3397,255.52552h-17.4294c-3.74751,0 -6.7957,-3.04876 -6.7957,-6.7957c0,-0.03952 -0.03207,-0.0716 -0.0716,-0.0716h-13.72141c-0.03952,0 -0.0716,0.03207 -0.0716,0.0716c0,11.39203 9.26827,20.6603 20.6603,20.6603h17.4294c11.3926,0 20.6603,-9.26827 20.6603,-20.6603c0,-11.39203 -9.26827,-20.6603 -20.6603,-20.6603h-17.4294c-3.74751,0 -6.7957,-3.04876 -6.7957,-6.7957c0,-3.74694 3.04818,-6.7957 6.7957,-6.7957h17.4294c3.74751,0 6.7957,3.04876 6.7957,6.7957c0,0.03952 0.03207,0.0716 0.0716,0.0716h13.72141c0.03952,0 0.0716,-0.03207 0.0716,-0.0716c0,-11.39203 -9.26827,-20.6603 -20.6603,-20.6603h-17.4294c-11.3926,0 -20.6603,9.26827 -20.6603,20.6603c0,11.39203 9.26827,20.6603 20.6603,20.6603h17.4294c3.74751,0 6.7957,3.04876 6.7957,6.7957c0,3.74694 -3.04818,6.7957 -6.7957,6.7957z" />
                    </g>
                </g>
            </g>
        </svg>
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
