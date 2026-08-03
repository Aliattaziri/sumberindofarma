@php
    $storeName = 'Alfa Mempawah';
    $storeDescription = 'Outlet Alfa Mempawah memiliki halaman katalog khusus untuk memudahkan pelanggan melihat produk yang tersedia.';
    $badgeText = 'Apotek Alfa Mempawah';
    $accentColor = '#6d28d9';
    $accentSoft = '#f5f3ff';
    $routeName = 'products.apotek';
    $routeSlug = 'alfa-mempawah';
    $storeAddress = 'Jl. Sujarwo, Terusan, Kecamatan Mempawah Hilir, Kabupaten Mempawah, Kalimantan Barat 78912';
    $storeWa = '6285820712029';
@endphp

@include('partials.store_catalog', get_defined_vars())
