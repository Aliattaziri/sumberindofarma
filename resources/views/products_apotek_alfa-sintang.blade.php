@php
    $storeName = 'Alfa Sintang';
    $storeDescription = 'Katalog resmi outlet Alfa Sintang dengan tampilan khusus untuk memudahkan pelanggan melihat produk yang tersedia.';
    $badgeText = 'Apotek Alfa Sintang';
    $accentColor = '#b91c1c';
    $accentSoft = '#fef2f2';
    $routeName = 'products.apotek';
    $routeSlug = 'alfa-sintang';
    $storeAddress = 'Jl. MT. Haryono, Kapuas Kanan Hulu, Kecamatan Sintang, Kabupaten Sintang, Kalimantan Barat 78613';
    $storeWa = '6285705935715';
@endphp

@include('partials.store_catalog', get_defined_vars())
