<!DOCTYPE html>

<html lang="en">

@include('template.partial.head')

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        @include('template.partial.navbar')
        <div class="content-wrapper">
            @include('template.partial.content-header')
            @yield('content')
        </div>
        @include('template.partial.footer')
    </div>
    @include('template.partial.script')
</body>
</html>
