@php
    $storeName = 'Alfa Kembayan';
    $storeDescription = 'Halaman katalog outlet Alfa Kembayan yang tampil elegant dan memudahkan pencarian produk.';
    $badgeText = 'Apotek Alfa Kembayan';
    $accentColor = '#4338ca';
    $accentSoft = '#eef2ff';
    $routeName = 'products.apotek';
    $routeSlug = 'alfa-kembayan';
    $storeAddress = 'APOTEK ALFA, Tj. Merpati, Kecamatan Kembayan, Kabupaten Sanggau, Kalimantan Barat 78516';
    $storeWa = '6285796032366';
@endphp

@include('partials.store_catalog', get_defined_vars())
