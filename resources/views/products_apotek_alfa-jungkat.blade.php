@php
    $storeName = 'Alfa Jungkat';
    $storeDescription = 'Katalog khusus Alfa Jungkat dengan penampakan yang lebih segar untuk memperkenalkan produk kesehatan.';
    $badgeText = 'Apotek Alfa Jungkat';
    $accentColor = '#b45309';
    $accentSoft = '#fffbeb';
    $routeName = 'products.apotek';
    $routeSlug = 'alfa-jungkat';
    $storeAddress = 'Jl. Raya Jungkat, Sei Nipah, Kecamatan Jongkat, Kabupaten Mempawah, Kalimantan Barat 78351';
    $storeWa = '6285754979060';
@endphp

@include('partials.store_catalog', get_defined_vars())
