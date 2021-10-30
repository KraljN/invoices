<!DOCTYPE html>
<html>

@include('fixed.header')

@auth
    @include('fixed.navigation')
@endauth

@yield('content')

@include('fixed.scripts')

</html>


