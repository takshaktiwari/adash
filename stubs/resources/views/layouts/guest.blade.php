<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        @vite(['resources/guest/css/guest.css', 'resources/guest/js/guest.js'])

        <style>
            body { background-color: #eaeaea; }
            .auth-card .logo svg { max-width: 80px; }
        </style>
    </head>
    <body>
        <div class="container py-5">
            {{ $slot }}
        </div>
    </body>
</html>
