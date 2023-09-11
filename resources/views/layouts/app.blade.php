<!doctype html>
<html lang="en">

@include('partials.head')

<body style="background-color:#e9ecef;">

    @include('partials.loader')

    @yield('header')

    <!-- App Capsule -->
    <div id="appCapsule">
        @include('sweetalert::alert')
        @yield('content')
    </div>
    <!-- * App Capsule -->

    @include('partials.bottomNav')

    @include('partials.script')

</body>

</html>