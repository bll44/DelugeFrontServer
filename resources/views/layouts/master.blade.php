<!DOCTYPE html>
<html lang="en">

@include('layouts.header')

<body>

<!-- main area for page content -->
<div class="container">

	@yield('content')

</div>


@yield('scripts')

</body>

@include('layouts.footer')

</html>