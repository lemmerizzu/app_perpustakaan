<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Perpustakaan Digital Kampus')</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: sans-serif; margin: 0; color: #1f2937; }
        nav { background: #1e3a8a; padding: 14px 40px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; }
        nav .brand { color: #fff; font-weight: bold; font-size: 18px; }
        nav ul { list-style: none; display: flex; gap: 20px; margin: 0; padding: 0; }
        nav ul li a { color: #cbd5e1; text-decoration: none; padding: 6px 4px; }
        nav ul li a.active { color: #fff; font-weight: bold; border-bottom: 2px solid #fff; }
        main { max-width: 900px; margin: 0 auto; padding: 30px 40px; }
        table { border-collapse: collapse; width: 100%; margin-top: 16px; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
        .alert-success { background: #d1fae5; color: #065f46; padding: 10px 14px; border-radius: 4px; margin-bottom: 16px; }
        .error { color: #b91c1c; font-size: 14px; margin-top: 4px; }
        .badge-aktif { color: #065f46; background: #d1fae5; padding: 2px 8px; border-radius: 4px; font-weight: bold; }
        .badge-nonaktif { color: #991b1b; background: #fee2e2; padding: 2px 8px; border-radius: 4px; font-weight: bold; }
        .btn { display: inline-block; padding: 6px 14px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        form.inline { display: inline; }
        footer { text-align: center; padding: 20px; color: #6b7280; font-size: 14px; border-top: 1px solid #e5e7eb; margin-top: 40px; }
        /* Form styles */
        .form-wrap { max-width: 560px; }
        .form-group { margin-top: 14px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 5px; color: #374151; }
        .form-group input,
        .form-group select,
        .form-group textarea { width: 100%; padding: 8px 10px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px; color: #1f2937; background: #fff; }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 2px rgba(37,99,235,0.15); }
        .form-actions { margin-top: 20px; }
        /* Pagination */
        .pagination-wrap { margin-top: 18px; }
        .pagination-info { color: #6b7280; font-size: 14px; margin: 0 0 8px; }
        .pagination { list-style: none; display: flex; flex-wrap: wrap; gap: 6px; margin: 0; padding: 0; }
        .pagination li a,
        .pagination li span { display: inline-block; padding: 6px 12px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px; text-decoration: none; color: #1f2937; background: #fff; }
        .pagination li a:hover { background: #eff6ff; border-color: #2563eb; color: #1d4ed8; }
        .pagination li span.active { background: #2563eb; border-color: #2563eb; color: #fff; font-weight: bold; }
        .pagination li span.disabled { color: #9ca3af; background: #f9fafb; }
    </style>
</head>
<body>
    @include('partials.navbar')
    <main>
        @include('partials.alert')
        @yield('content')
    </main>
    <footer>&copy; {{ date('Y') }} Sistem Perpustakaan Digital Kampus</footer>
</body>
</html>
