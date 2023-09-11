<!DOCTYPE html>
<html lang="en">

@include('partials.admin.head')

<body>
    <div id="app">

        @include('partials.admin.sidebar')
        <div id="main" class='layout-navbar'>

            @include('partials.admin.navbar')

            <div id="main-content">

                @yield('content')

                {{-- @include('partials.admin.footer') --}}

            </div>
        </div>
    </div>

    @include('partials.admin.script')
</body>

</html>