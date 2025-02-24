<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<link rel="icon" type="image/png" href="{{ asset('assets/img/icon.png') }}">
	<title>SITA | {{ $title }}</title>
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="{{ asset('assets/js/script.js') }}"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
	@include('partials.header')
    @include('partials.sidebar') 
	@yield('container')
</body>
</html>