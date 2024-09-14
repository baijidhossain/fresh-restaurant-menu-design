<header class="sticky top-0 z-999 flex w-full bg-white drop-shadow-1">
    <div class="flex flex-grow items-center justify-between px-4 py-4 shadow-2 md:px-6 2xl:px-11">
        <div class="flex items-center gap-2 sm:gap-4 lg:hidden">

            <button class="block rounded-sm border border-stroke p-1.5 shadow-sm"
                @click.stop="sidebarToggle = !sidebarToggle">
                <span class="relative block h-5.5 w-5.5 cursor-pointer">
                    <span class="du-block absolute right-0 h-full w-full">
                        <span
                            class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-[0] duration-200 ease-in-out"
                            :class="{ '!w-full delay-300': !sidebarToggle }"></span>
                        <span
                            class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-150 duration-200 ease-in-out"
                            :class="{ '!w-full delay-400': !sidebarToggle }"></span>
                        <span
                            class="relative left-0 top-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-200 duration-200 ease-in-out"
                            :class="{ '!w-full delay-500': !sidebarToggle }"></span>
                    </span>
                    <span class="du-block absolute right-0 h-full w-full rotate-45">
                        <span
                            class="absolute left-2.5 top-0 block h-full w-0.5 rounded-sm bg-black delay-300 duration-200 ease-in-out"
                            :class="{ '!h-0 delay-[0]': !sidebarToggle }"></span>
                        <span
                            class="delay-400 absolute left-0 top-2.5 block h-0.5 w-full rounded-sm bg-black duration-200 ease-in-out"
                            :class="{ '!h-0 dealy-200': !sidebarToggle }"></span>
                    </span>
                </span>
            </button>
            <!-- Hamburger Toggle BTN -->
            <a class="block flex-shrink-0 lg:hidden" href="index.html">
                GoCards
            </a>
        </div>



        <div class="hidden sm:block">
            <form action="{{ route('restaurant_user.index') }}" method="GET" class="mb-0">
                <div class="relative">
                    <button class="absolute left-0 top-1/2 -translate-y-1/2">
                        <i class="fa-duotone fa-magnifying-glass"></i>
                    </button>

                    <input type="text" placeholder="Type to search restaurant_user..." name="search"
                        class="w-full bg-transparent pl-9 pr-4 focus:outline-none xl:w-125">
                </div>
            </form>
        </div>


        <div class="flex items-center gap-3 2xsm:gap-7">


            <!-- User Area -->
            <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
                <a class="flex items-center gap-4" href="#" @click.prevent="dropdownOpen = ! dropdownOpen">
                    <span class="hidden text-right lg:block">
                        <span class="block text-sm font-medium text-black">
                            {{ Auth::user()->name }}
                        </span>
                        <span class="block text-xs font-medium">
                            {{ Auth::user()->email }}
                        </span>
                    </span>

                    <span class="rounded-full">
                        <i class="fa-duotone fa-user-crown fa-2x"></i>
                    </span>

                    <i class="fa-duotone fa-chevron-down hidden sm:block" :class="dropdownOpen && 'rotate-180'"></i>
                </a>
                <!-- Dropdown Start -->
                <div x-show="dropdownOpen"
                    class="absolute right-0 mt-4 flex w-62.5 flex-col rounded-sm border border-stroke bg-white shadow-default">
                    <ul class="flex flex-col gap-5 border-b border-stroke px-6 py-4">
                        <li>
                            <a href="{{ route('admin.profile.show') }}"
                                class="flex items-center gap-3.5 text-sm font-medium duration-300 ease-in-out hover:text-primary lg:text-base">
                                <i class="fa-duotone fa-user"></i>
                                {{ __('Profile') }}
                            </a>
                        </li>
                    </ul>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('admin.logout') }}" class="mb-0">
                        @csrf
                        <a class="flex items-center gap-3.5 px-6 py-4 text-sm font-medium duration-300 ease-in-out hover:text-primary lg:text-base"
                            href="{{ route('admin.logout') }}"
                            onclick="event.preventDefault();
                     this.closest('form').submit();">
                            <i class="fa-duotone fa-sign-out"></i>
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
                <!-- Dropdown End -->
            </div>
            <!-- User Area -->
        </div>
    </div>
</header>
