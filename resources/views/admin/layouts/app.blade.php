<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
       GoCards - Admin Panel
    </title>
    <link rel="icon" href="favicon.ico">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('assets/notyf@3/notyf.min.css')}}">

    <link href="{{asset('assets/font-awesome-6-pro-main/css/all.css')}}" rel="stylesheet" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    @stack('styles')

</head>

<body x-data="{ page: 'ecommerce', 'loaded': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }">

    {{-- Page Wrapper Start --}}
    <div class="flex h-screen overflow-hidden">

        @auth
            {{-- Sidebar Start --}}
             @include('admin.layouts.sidebar')
            {{-- Sidebar End --}}
        @endauth



        {{-- Content Area Start --}}
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">

            @auth
                {{-- Header Start --}}
                @include('admin.layouts.header')
                {{-- Header End --}}
            @endauth

            {{-- Main Content Start --}}
            @yield('content')
            {{-- Main Content End --}}

        </div>

        {{-- Content Area End --}}

    </div>
    {{-- Page Wrapper End --}}

    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/qrcode-with-logos@1.0.5/lib/qrcode-with-logos.min.js"></script>



    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    
    @if (session()->has('success'))
    <script>
        var notyf = new Notyf({
            dismissible: true,
            duration: 2000
        })
        notyf.success('{{ session('success') }}')
    </script>



@endif

    <script>
        /* Simple Alpine Image Viewer */
        document.addEventListener('alpine:init', () => {
            Alpine.data('imageViewer', (src = '') => {
                return {
                    imageUrl: src,

                    refreshUrl() {
                        this.imageUrl = this.$el.getAttribute("image-url")
                    },

                    fileChosen(event) {
                        this.fileToDataUrl(event, src => this.imageUrl = src)
                    },

                    fileToDataUrl(event, callback) {
                        if (!event.target.files.length) return

                        let file = event.target.files[0],
                            reader = new FileReader()

                        reader.readAsDataURL(file)
                        reader.onload = e => callback(e.target.result)
                    },
                }
            })
        })
    </script>

@stack('scripts')

</body>

</html>
