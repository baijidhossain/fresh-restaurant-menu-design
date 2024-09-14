@extends('admin.layouts.app')

@section('content')
    <main>
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">

                <div
                    class="relative flex items-center rounded-[10px] bg-white py-10 px-6 shadow-1 sm:px-10 md:px-6 xl:px-10">
                    <div
                        class="mr-4 flex h-[50px] w-full max-w-[50px] items-center justify-center rounded-full bg-primary text-white sm:mr-6 sm:h-[60px] sm:max-w-[60px] md:mr-4 md:h-[50px] md:max-w-[50px] xl:mr-6 xl:h-[60px] xl:max-w-[60px]">
                        <i class="fa-duotone fa-user-crown"></i>
                    </div>
                    <div>
                        <p class="font-bold text-dark text-2xl xl:leading-[35px] xl:text-[28px]">
                            {{ $users }}
                        </p>
                        <p class="mt-1 text-base text-body-color">
                            Total Users
                        </p>
                    </div>

                </div>

                <div
                    class="relative flex items-center rounded-[10px] bg-white py-10 px-6 shadow-1 sm:px-10 md:px-6 xl:px-10">
                    <div
                        class="mr-4 flex h-[50px] w-full max-w-[50px] items-center justify-center rounded-full bg-primary text-white sm:mr-6 sm:h-[60px] sm:max-w-[60px] md:mr-4 md:h-[50px] md:max-w-[50px] xl:mr-6 xl:h-[60px] xl:max-w-[60px]">
                        <i class="fa-duotone fa-list-ol"></i>
                    </div>
                    <div>
                        <p class="font-bold text-dark text-2xl xl:leading-[35px] xl:text-[28px]">
                            {{ $codes }}
                        </p>
                        <p class="mt-1 text-base text-body-color">
                            Total Codes
                        </p>
                    </div>

                </div>

                <div
                    class="relative flex items-center rounded-[10px] bg-white py-10 px-6 shadow-1 sm:px-10 md:px-6 xl:px-10">
                    <div
                        class="mr-4 flex h-[50px] w-full max-w-[50px] items-center justify-center rounded-full bg-primary text-white sm:mr-6 sm:h-[60px] sm:max-w-[60px] md:mr-4 md:h-[50px] md:max-w-[50px] xl:mr-6 xl:h-[60px] xl:max-w-[60px]">
                        <i class="fa-duotone fa-binary-circle-check"></i>
                    </div>
                    <div>
                        <p class="font-bold text-dark text-2xl xl:leading-[35px] xl:text-[28px]">
                            {{ $availableCodes }}
                        </p>
                        <p class="mt-1 text-base text-body-color">
                            Available Codes
                        </p>
                    </div>

                </div>

                <div
                    class="relative flex items-center rounded-[10px] bg-white py-10 px-6 shadow-1 sm:px-10 md:px-6 xl:px-10">
                    <div
                        class="mr-4 flex h-[50px] w-full max-w-[50px] items-center justify-center rounded-full bg-primary text-white sm:mr-6 sm:h-[60px] sm:max-w-[60px] md:mr-4 md:h-[50px] md:max-w-[50px] xl:mr-6 xl:h-[60px] xl:max-w-[60px]">
                        <i class="fa-duotone fa-address-book"></i>
                    </div>
                    <div>
                        <p class="font-bold text-dark text-2xl xl:leading-[35px] xl:text-[28px]">
                            {{ $restaurant_user }}
                        </p>
                        <p class="mt-1 text-base text-body-color">
                            Total restaurant_user
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </main>
@endsection

