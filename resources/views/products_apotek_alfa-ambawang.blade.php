@php
    $storeName = 'Alfa Ambawang';
    $storeDescription = 'Tampilan katalog Alfa Ambawang yang simpel, modern, dan fokus pada kebutuhan pelanggan harian.';
    $badgeText = 'Apotek Alfa Ambawang';
    $accentColor = '#0f766e';
    $accentSoft = '#ecfeff';
    $routeName = 'products.apotek';
    $routeSlug = 'alfa-ambawang';
    $storeAddress = 'Jl. Trans Kalimantan, Desa Jawa Tengah, Kecamatan Sui Ambawang, Kabupaten Kubu Raya, Kalimantan Barat 78319';
    $storeWa = '6285119413105';
@endphp

@include('partials.store_catalog', get_defined_vars())
