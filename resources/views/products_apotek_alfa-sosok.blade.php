@php
    $storeName = 'Alfa Sosok';
    $storeDescription = 'Halaman katalog khusus untuk Alfa Sosok dengan visual yang lebih fresh dan fokus pada produk kesehatan.';
    $badgeText = 'Apotek Alfa Sosok';
    $accentColor = '#be185d';
    $accentSoft = '#fdf2f8';
    $routeName = 'products.apotek';
    $routeSlug = 'alfa-sosok';
    $storeAddress = 'Sosok, Kecamatan Tayan Hulu, Kabupaten Sanggau, Kalimantan Barat 78562';
    $storeWa = '6285796032370';
@endphp

@include('partials.store_catalog', get_defined_vars())
