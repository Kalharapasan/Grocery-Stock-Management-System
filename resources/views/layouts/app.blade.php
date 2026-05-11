<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Grocery Stock Manager')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
        }

        .stock-badge-danger {
            background-color: #dc3545;
        }

        .stock-badge-warning {
            background-color: #ffc107;
            color: #000;
        }

        .stock-badge-success {
            background-color: #198754;
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-radius: 0.375rem;
        }
    </style>
</head>


<body>

</body>



</html>
