<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <!-- <link rel="stylesheet" href="{{ asset('app.css') }}"> -->
    @if (file_exists(public_path('hot')))
        @vite('resources/css/app.css')
    @else
        <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}">
    @endif
</head>
<body class="h-screen bg-gray-100">