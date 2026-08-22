<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#991B1B">
    <meta name="msapplication-TileColor" content="#991B1B">
    @php
        $faviconV = @filemtime(public_path('favicon.ico')) ?: '20260803-13';
    @endphp
    <meta property="og:image" content="{{ asset('logo pt sumber indo farma tama.png') }}?v=20260803-8">
    <meta property="og:image:secure_url" content="{{ asset('logo pt sumber indo farma tama.png') }}?v=20260803-8">
    <meta name="twitter:image" content="{{ asset('logo pt sumber indo farma tama.png') }}?v=20260803-8">
    <title>@yield('title', 'Sumberindo Farma Tama - Apotik Online')</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico?v={{ $faviconV }}">
    <link rel="shortcut icon" href="/favicon.ico?v={{ $faviconV }}">
    
    <!-- FIX CURSOR - MUST BE FIRST TO OVERRIDE EVERYTHING -->
    <style>
        /* FORCE RESET CURSOR - HIGHEST PRIORITY */
        html, html *, html *::before, html *::after,
        body, body *, body *::before, body *::after {
            cursor: auto !important;
        }
        a, a *, button, button *, [role="button"], [onclick], 
        input[type="button"], input[type="submit"], input[type="reset"], select {
            cursor: pointer !important;
        }
        input[type="text"], input[type="email"], input[type="password"],
        input[type="search"], input[type="tel"], input[type="url"],
        input[type="number"], textarea {
            cursor: text !important;
        }
        [disabled], .disabled {
            cursor: not-allowed !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/fix-cursor.css') }}">
    
    <!-- Fix Cursor Script - Load ASAP -->
    <script>
        // Immediate cursor fix - runs before page loads
        (function() {
            'use strict';
            function fix() {
                document.documentElement.style.setProperty('cursor', 'auto', 'important');
                if (document.body) {
                    document.body.style.setProperty('cursor', 'auto', 'important');
                }
            }
            fix();
            setInterval(fix, 100);
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', fix);
            }
        })();
    </script>
    
    <!-- Font Awesome (switched to jsDelivr mirror to avoid CDN font issues) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ===== BOOTSTRAP GRID REPLACEMENT ===== */
        *, *::before, *::after { box-sizing: border-box; }
        html, body { overflow-x: hidden; max-width: 100%; }        html { min-height: 100%; }
        body { margin: 0; display: flex; flex-direction: column; min-height: 100vh; }
        img, svg, video { max-width: 100%; height: auto; display: block; }
        button, input, textarea, select { max-width: 100%; }
        .container { width: 100%; max-width: 100%; padding-left: 1rem; padding-right: 1rem; margin-left: auto; margin-right: auto; }
        @media (max-width: 480px) {
            .container { padding-left: 0.75rem; padding-right: 0.75rem; }
        }
        .row { display: flex; flex-wrap: wrap; margin-left: -0.75rem; margin-right: -0.75rem; }
        .row > * { padding-left: 0.75rem; padding-right: 0.75rem; width: 100%; }
        .col-lg-6 { flex: 0 0 auto; }
        .col-lg-5 { flex: 0 0 auto; }
        .col-lg-7 { flex: 0 0 auto; }
        @media (min-width: 992px) {
            .col-lg-6 { width: 50%; }
            .col-lg-5 { width: 41.6667%; }
            .col-lg-7 { width: 58.3333%; }
            .d-none { display: none !important; }
            .d-lg-block { display: block !important; }
            .align-items-center { align-items: center !important; }
        }
        @media (max-width: 991px) {
            .col-lg-6, .col-lg-5, .col-lg-7 { width: 100%; }
            .d-none { display: none !important; }
        }
        .g-5 { gap: 1.5rem; }
        .g-3 { gap: 1rem; }

        /* ===== GLOBAL SECTION DECORATIONS ===== */

        /* Header pages */
        .about-header, .contact-header, .act-header,
        .news-page-header, .products-header, .page-header {
            position: relative;
            overflow: hidden;
        }

        /* Floating deco icons di semua header */
        .header-deco-icon {
            position: absolute;
            color: rgba(255,255,255,0.08);
            pointer-events: none;
            animation: headerIconFloat 6s ease-in-out infinite;
        }
        .header-deco-icon-1 { bottom: 10px; right: 12%; font-size: 4rem;   animation-delay: 0s; }
        .header-deco-icon-2 { top: 15px;   right: 28%; font-size: 3rem;   animation-delay: 2s; }
        .header-deco-icon-3 { bottom: 20px; right: 40%; font-size: 2.5rem; animation-delay: 4s; }

        @keyframes headerIconFloat {
            0%, 100% { transform: translateY(0) rotate(0deg);   opacity: 0.08; }
            50%       { transform: translateY(-12px) rotate(8deg); opacity: 0.15; }
        }

        /* Stats bar */
        .stats-bar { position: relative; overflow: hidden; }
        .stats-bar::before {
            content: '';
            position: absolute;
            top: -40px; left: -40px;
            width: 180px; height: 180px;
            background: radial-gradient(circle, rgba(220,38,38,0.07) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }
        .stats-bar::after {
            content: '';
            position: absolute;
            bottom: -40px; right: -40px;
            width: 160px; height: 160px;
            background: radial-gradient(circle, rgba(220,38,38,0.07) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }

        /* Products section */
        .products-section { position: relative; overflow: hidden; }
        .products-section::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(220,38,38,0.05) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }
        .products-section::after {
            content: '';
            position: absolute;
            bottom: 40px; left: -80px;
            width: 250px; height: 250px;
            background: radial-gradient(circle, rgba(220,38,38,0.05) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }

        /* About section */
        .about-section { position: relative; overflow: hidden; }
        .about-section::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(220,38,38,0.04) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }
        .about-section::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(220,38,38,0.05) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }

        /* About/contact/act main */
        .about-main, .contact-main, .act-main { position: relative; overflow: hidden; }
        .about-main::before, .contact-main::before, .act-main::before {
            content: '';
            position: absolute;
            top: 0; right: -100px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(220,38,38,0.03) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }

        /* Section card subtle deco */
        .section-card { position: relative; overflow: hidden; }
        .section-card::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 120px; height: 120px;
            background: radial-gradient(circle, rgba(220,38,38,0.04) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }

        /* Footer */
        .footer { position: relative; overflow: hidden; }
        .footer::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(220,38,38,0.05) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }
        .footer::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(220,38,38,0.04) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none;
        }

        /* ===== CARD DECORATIONS ===== */
        .medicine-card, .news-card, .news-preview-card, .photo-card,
        .feature-item, .section-card, .vm-card, .value-item,
        .stat-box, .info-card, .form-card, .detail-container,
        .news-detail-content, .about-image-main, .float-stat {
            position: relative;
            overflow: hidden;
        }

        /* Blob kanan atas - biru */
        .medicine-card::before,
        .news-card::before,
        .news-preview-card::before,
        .feature-item::before,
        .value-item::before,
        .info-card::before,
        .form-card::before,
        .detail-container::before,
        .news-detail-content::before {
            content: '';
            position: absolute;
            top: -25px; right: -25px;
            width: 90px; height: 90px;
            background: radial-gradient(circle, rgba(220,38,38,0.07) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        /* Blob kiri bawah - hijau */
        .medicine-card::after,
        .news-card::after,
        .news-preview-card::after,
        .photo-card::after,
        .feature-item::after,
        .section-card::after,
        .vm-card::after,
        .stat-box::after,
        .info-card::after,
        .form-card::after,
        .detail-container::after,
        .news-detail-content::after,
        .about-image-main::after,
        .float-stat::after {
            content: '';
            position: absolute;
            bottom: -20px; right: -20px;
            width: 75px; height: 75px;
            background: radial-gradient(circle, rgba(220,38,38,0.08) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        /* Section card blob lebih besar */
        .section-card::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 120px; height: 120px;
            background: radial-gradient(circle, rgba(220,38,38,0.05) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        /* ===== BACKGROUND DEKORATIF ===== */
        .med-particles {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        /* Blob / lingkaran blur besar */
        .mp-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: var(--o, 0.18);
        }

        /* Ring / cincin outline */
        .mp-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(185,28,28,var(--bo, 0.10));
            background: transparent;
            opacity: var(--o, 1);
        }

        /* Persegi panjang miring */
        .mp-rect {
            position: absolute;
            border-radius: 10px;
            background: rgba(185,28,28,var(--o, 0.05));
            transform: rotate(var(--r, 30deg));
        }

        /* Garis panjang diagonal */
        .mp-line {
            position: absolute;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(185,28,28,0.15), transparent);
            transform: rotate(var(--r, -25deg));
            transform-origin: left center;
        }

        /* Dot grid pattern (pseudo-element trick) */
        .mp-dotgrid {
            position: absolute;
            background-image: radial-gradient(circle, rgba(185,28,28,0.13) 1px, transparent 1px);
            background-size: 22px 22px;
            opacity: var(--o, 0.6);
            border-radius: 4px;
        }
    </style>
    
    <style>
        :root {
            --primary: #B91C1C;
            --secondary: #991B1B;
            --accent: #ef4444;
            --dark: #1f2937;
            --light: #f3f4f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            margin: 0 !important;
            padding: 0 !important;
            font-size: 16px;
            line-height: 1.5;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: var(--navbar-height, 65px);
            background:
                radial-gradient(ellipse 80% 50% at 10% 0%,   rgba(253,232,232,0.85) 0%, transparent 60%),
                radial-gradient(ellipse 60% 40% at 90% 20%,  rgba(254,226,226,0.60) 0%, transparent 55%),
                radial-gradient(ellipse 50% 60% at 50% 80%,  rgba(254,242,242,0.70) 0%, transparent 60%),
                radial-gradient(ellipse 70% 40% at 80% 100%, rgba(253,232,232,0.50) 0%, transparent 55%),
                #fff8f8;
            background-attachment: fixed;
            min-height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: transparent;
            color: var(--dark);
            padding-top: var(--navbar-height, 65px);
        }

        main {
            flex: 1 0 auto;
            padding: 1rem 0;
        }

        /* Semua konten di atas canvas */
        main, footer {
            position: relative;
            z-index: 1;
        }

        /* Pastikan footer selalu di bawah dan tidak dikecilkan */
        footer.footer {
            flex-shrink: 0;
        }
        .float-wrap {
            position: relative;
            z-index: 999;
        }
        /* Cart dan overlay harus di atas segalanya */
        #cartDrawer, .cart-overlay {
            z-index: 2001 !important;
        }

        /* Global card style - minimal, non-overriding */
        .farma-sidebar, .disease-card, .farma-stat-card {
            background: rgba(255,255,255,0.94);
            backdrop-filter: blur(8px);
        }

        /* Section backgrounds */
        .products-main, .farma-main, .act-main,
        .news-main, .about-main, .contact-main,
        .products-section, .features-section,
        .search-section-wrap {
            background: transparent !important;
        }

        .stats-bar, .about-section, .visi-misi-section,
        .team-section, .news-preview-section {
            background: rgba(255,255,255,0.55) !important;
            backdrop-filter: blur(6px);
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #991B1B 0%, #B91C1C 50%, #B91C1C 100%);
            box-shadow: 0 4px 20px rgba(220,38,38,0.25), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            padding: 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            margin: 0 !important;
            z-index: 1100;
            border-bottom: 2px solid rgba(124, 179, 66, 0.4);
        }

        body {
            padding-top: 0;
        }

        .page-offset {
            padding-top: var(--navbar-height, 65px);
        }

        .category-page-header,
        .contact-header,
        .farma-header,
        .act-header,
        .news-page-header,
        .medicines-detail-header,
        .about-page-header {
            padding-top: calc(var(--navbar-height, 65px) + 2.5rem) !important;
            padding-bottom: 2.5rem;
        }

        .products-header {
            padding-top: calc(var(--navbar-height, 65px) + 1rem) !important;
            padding-bottom: 2.5rem;
        }

        /* about-hero adalah section pertama di halaman tentang kami */
        .about-hero {
            padding-top: calc(var(--navbar-height, 65px) + 2rem) !important;
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .navbar-brand {
            font-size: 1.45rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            transition: transform 0.25s ease;
            flex-shrink: 0;
            white-space: nowrap;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
            text-shadow: 0 2px 10px rgba(0,0,0,0.25);
        }

        .navbar-brand img {
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.22));
            height: 44px;
            object-fit: contain;
            margin-left: -4px;
            background: rgba(255, 255, 255, 0.96);
            border-radius: 1rem;
            padding: 0.4rem;
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.75);
        }

        .navbar-menu {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            list-style: none;
            flex-wrap: wrap;
            justify-content: flex-end;
            flex: 1 1 auto;
            margin: 0;
            padding: 0;
        }

        .navbar-menu li {
            margin: 0;
        }

        .navbar-menu li {
            list-style: none;
        }

        .navbar-menu a,
        .navbar-menu .logout-btn {
            color: white;
            text-decoration: none;
            transition: transform 0.2s ease, background 0.25s ease, color 0.25s ease, box-shadow 0.25s ease;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.55rem 0.9rem;
            border-radius: 0.65rem;
            font-size: 0.95rem;
            white-space: nowrap;
            position: relative;
            overflow: hidden;
        }

        .navbar-menu a::before,
        .navbar-menu .logout-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.08);
            opacity: 0;
            transition: opacity 0.25s ease, transform 0.25s ease;
            transform: scale(0.95);
            border-radius: 0.65rem;
            pointer-events: none;
        }

        .navbar-menu a:hover::before,
        .navbar-menu .logout-btn:hover::before {
            opacity: 1;
            transform: scale(1);
        }

        .navbar-menu a:hover,
        .navbar-menu .logout-btn:hover {
            background: rgba(255, 255, 255, 0.16);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .navbar-menu .logout-btn {
            background: rgba(220, 38, 38, 0.2);
            border: 1px solid rgba(220, 38, 38, 0.4);
            cursor: pointer;
            width: auto;
            text-align: center;
            font-size: 1rem;
        }

        .navbar-menu .logout-btn:hover {
            background: rgba(220, 38, 38, 0.3);
        }

        .navbar-menu .admin-link {
            color: #fee2e2;
        }

        .footer-socials {
            display: flex;
            flex-wrap: nowrap;
            gap: 0.5rem;
            margin-top: 1rem;
            justify-content: flex-start;
            align-items: center;
            width: fit-content;
        }

        .social-circle {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: rgba(255,255,255,0.12);
            color: white;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
            flex-shrink: 0;
            box-shadow: none;
            padding: 0;
            overflow: hidden;
        }
        .social-circle:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.2);
            filter: brightness(1.05);
        }
        .social-circle img {
            width: 16px;
            height: 16px;
            object-fit: contain;
            display: block;
        }
        .footer-content .footer-socials a {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            padding: 0;
            border-radius: 8px;
            overflow: hidden;
        }

        .social-circle:hover {
            background: rgba(255,255,255,0.25);
        }

        /* Social Media Color */
        .social-circle.social-instagram {
            background: linear-gradient(135deg, #f09433 0%, #e6683c 50%, #dc2743 100%);
        }
        .social-circle.social-instagram:hover {
            background: linear-gradient(135deg, #e6683c 0%, #dc2743 50%, #cc2366 100%);
            transform: scale(1.1);
        }
        
        .social-circle.social-whatsapp {
            background: #25D366;
        }
        .social-circle.social-whatsapp:hover {
            background: #1f8f4a;
            transform: scale(1.1);
        }
        
        .social-circle.social-tiktok {
            background: #000000;
        }
        .social-circle.social-tiktok:hover {
            background: #333333;
            transform: scale(1.1);
        }
        
        .social-circle.social-shopee {
            background: #EE3131;
        }
        .social-circle.social-shopee:hover {
            background: #C41C1C;
            transform: scale(1.1);
        }

        .footer-icon {
            margin-right: 0.6rem;
            color: #25D366;
            min-width: 1rem;
        }

        /* Dropdown nav */
        .navbar-menu .has-dropdown { position: relative; }
        .navbar-menu .dropdown-menu-nav {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            min-width: 200px;
            padding: 0.5rem 0;
            z-index: 999;
            list-style: none;
            margin: 0;
            border: 1px solid #e5e7eb;
        }
        .navbar-menu .has-dropdown:hover .dropdown-menu-nav { display: block; }
        .navbar-menu .dropdown-menu-nav li a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            color: #374151 !important;
            font-size: 0.875rem;
            font-weight: 600;
            background: transparent !important;
            border-radius: 0;
            white-space: nowrap;
        }
        .navbar-menu .dropdown-menu-nav li a:hover {
            background: #f3f4f6 !important;
            color: #B91C1C !important;
        }

        .admin-login-item a {
            padding: 0.5rem 0.6rem;
            font-size: 1rem;
        }

        /* Cart button di navbar */
        .cart-nav-btn {
            position: relative; background: none; border: none; cursor: pointer;
            color: white; padding: 0.5rem 0.6rem; border-radius: 0.375rem;
            font-size: 1rem; display: flex; align-items: center; transition: background 0.2s;
            flex-shrink: 0;
        }
        .cart-nav-btn:hover { background: rgba(255,255,255,0.2); }
        .cart-badge {
            position: absolute; top: 2px; right: 2px;
            background: #ef4444; color: white; font-size: 0.6rem; font-weight: 800;
            width: 16px; height: 16px; border-radius: 50%;
            display: none; align-items: center; justify-content: center;
        }

        /* Hamburger Menu */
        .hamburger-menu {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            background: none;
            border: none;
            z-index: 1001;
            padding: 0.5rem;
        }

        .hamburger-menu span {
            width: 25px;
            height: 3px;
            background: white;
            border-radius: 2px;
            transition: all 0.3s;
        }

        .hamburger-menu.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .hamburger-menu.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger-menu.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Footer */
        .footer {
            background: linear-gradient(180deg, #7F1D1D 0%, #B91C1C 100%) !important;
            color: white;
            padding: 3rem 0;
            margin-top: auto;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.75rem;
            margin-bottom: 2rem;
        }

        .footer-content > div {
            min-width: 220px;
        }

        .footer-content h3 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: #fecaca;
        }

        .footer-content ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .footer-content ul li {
            margin-bottom: 0.85rem;
        }

        .footer-content a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.25s ease;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            line-height: 1.5;
            font-size: 0.95rem;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        .footer-content a:hover {
            color: white;
        }

        .footer-content ul a,
        .footer-content > div:not(.footer-socials) a {
            width: 100%;
        }

        .footer-content span {
            color: #d1d5db;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .footer-content a {
                font-size: 0.84rem;
            }
            .social-circle {
                width: 36px;
                height: 36px;
            }
        }

        @media (max-width: 480px) {
            .footer-content a {
                font-size: 0.8rem;
                line-height: 1.4;
                gap: 0.4rem;
            }
            .footer-content h3 {
                font-size: 0.95rem;
            }
            .footer-icon {
                width: 1rem;
            }
            .footer-socials {
                display: flex;
                flex-wrap: nowrap;
                gap: 0.4rem;
                margin-top: 0.75rem;
                justify-content: flex-start;
                align-items: center;
                width: fit-content;
            }
            .social-circle {
                width: 28px !important;
                height: 28px !important;
                min-width: 28px;
                min-height: 28px;
                border-radius: 8px !important;
                padding: 0;
            }
            .footer-content .footer-socials a {
                width: 28px !important;
                height: 28px !important;
                min-width: 28px;
                min-height: 28px;
                border-radius: 8px !important;
                padding: 0;
            }
            .social-circle img {
                width: 13px;
                height: 13px;
            }
        }

        .footer-socials {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .social-circle {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(255,255,255,0.12);
            color: white;
            text-decoration: none;
            transition: background 0.25s ease;
        }

        .social-circle:hover {
            background: rgba(255,255,255,0.24);
        }

        /* Social Media Color */
        .social-circle.social-instagram {
            background: linear-gradient(135deg, #f09433 0%, #e6683c 50%, #dc2743 100%);
        }
        .social-circle.social-instagram:hover {
            background: linear-gradient(135deg, #e6683c 0%, #dc2743 50%, #cc2366 100%);
            transform: scale(1.1);
        }
        
        .social-circle.social-whatsapp {
            background: #25D366;
        }
        .social-circle.social-whatsapp:hover {
            background: #1f8f4a;
            transform: scale(1.1);
        }
        
        .social-circle.social-tiktok {
            background: #000000;
        }
        .social-circle.social-tiktok:hover {
            background: #333333;
            transform: scale(1.1);
        }
        
        .social-circle.social-shopee {
            background: #EE3131;
        }
        .social-circle.social-shopee:hover {
            background: #C41C1C;
            transform: scale(1.1);
        }

        .footer-icon {
            width: 1.2rem;
            color: #25D366;
            flex-shrink: 0;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.12);
            padding-top: 1.5rem;
            text-align: center;
            color: #9ca3af;
            font-size: 0.95rem;
        }

        .footer h3 {
            margin-bottom: 1rem;
            color: var(--accent);
        }

        .footer ul {
            list-style: none;
        }

        .footer ul li {
            margin-bottom: 0.5rem;
        }

        .footer ul a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer ul a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid #374151;
            padding-top: 2rem;
            text-align: center;
            color: #9ca3af;
        }

        /* Alert */
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #fee2e2;
            color: #065f46;
            border-left: 4px solid var(--primary);
        }

        .alert-error {
            background: #fee2e2;
            color: #7f1d1d;
            border-left: 4px solid #ef4444;
        }

        @media (max-width: 768px) {
            .hamburger-menu {
                display: flex;
            }

            .navbar-container {
                padding: 0.5rem 1rem;
            }

            .navbar-menu {
                position: fixed;
                left: 0;
                top: var(--navbar-height, 65px);
                width: 100%;
                background: linear-gradient(135deg, #991B1B 0%, #B91C1C 50%, #B91C1C 100%);
                flex-direction: column;
                justify-content: flex-start;
                gap: 0;
                padding: 0 1rem;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.35s ease, padding 0.35s ease;
                z-index: 999;
                box-shadow: 0 8px 24px rgba(13,71,161,0.35);
            }

            .navbar-menu.active {
                max-height: 100vh;
                padding: 1rem 1rem 1.5rem;
            }

            .navbar-menu li {
                width: 100%;
                margin-bottom: 0.4rem;
            }

            .navbar-menu a,
            .navbar-menu .logout-btn {
                padding: 0.95rem 1rem;
                font-size: 1rem;
                display: block;
            }

            .navbar-menu li {
                width: 100%;
                margin-bottom: 0.4rem;
            }

            .navbar-menu a,
            .navbar-menu .logout-btn {
                padding: 0.95rem 1rem;
                font-size: 1rem;
                display: block;
            }

            .navbar-menu li {
                width: 100%;
                margin-bottom: 0.25rem;
            }

            .navbar-menu a,
            .navbar-menu .logout-btn {
                padding: 0.875rem 1rem;
                font-size: 1rem;
                display: block;
            }

            .navbar-brand {
                font-size: 1rem;
            }

            .navbar-brand img {
                height: 45px;
            }
        }

        @media (max-width: 480px) {
            .navbar-brand {
                font-size: 0.85rem;
            }

            .navbar-brand img {
                height: 38px;
            }

            .navbar-container {
                padding: 0.5rem 0.75rem;
            }

            .navbar-menu {
                padding: 0 0.75rem;
            }

            .navbar-menu.active {
                padding: 0.75rem 0.75rem 1.25rem;
            }

            .navbar-menu a,
            .navbar-menu .logout-btn {
                padding: 0.75rem 0.875rem;
                font-size: 0.95rem;
            }
        }
    </style>

    @yield('styles')
</head>
<body>

    <!-- ===== BACKGROUND DEKORATIF ===== -->
    <div class="med-particles" aria-hidden="true">

        {{-- Blob warna hangat di sudut-sudut --}}
        <span class="mp-blob" style="width:700px;height:700px;top:-200px;left:-200px;background:radial-gradient(circle,#fca5a5,#fee2e2);--o:0.04;"></span>
        <span class="mp-blob" style="width:500px;height:500px;top:30%;right:-180px;background:radial-gradient(circle,#fecaca,transparent);--o:0.03;"></span>
        <span class="mp-blob" style="width:600px;height:400px;bottom:-100px;left:20%;background:radial-gradient(circle,#fde8e8,transparent);--o:0.04;"></span>
        <span class="mp-blob" style="width:300px;height:300px;top:55%;left:40%;background:radial-gradient(circle,#fca5a5,transparent);--o:0.02;"></span>

        {{-- Ring / cincin outline berlapis --}}
        <span class="mp-ring" style="width:520px;height:520px;top:-80px;right:-100px;--bo:0.08;"></span>
        <span class="mp-ring" style="width:360px;height:360px;top:-40px;right:-60px;--bo:0.06;"></span>
        <span class="mp-ring" style="width:280px;height:280px;top:38%;left:-60px;--bo:0.07;"></span>
        <span class="mp-ring" style="width:180px;height:180px;top:42%;left:-30px;--bo:0.05;"></span>
        <span class="mp-ring" style="width:420px;height:420px;bottom:-120px;right:5%;--bo:0.07;"></span>
        <span class="mp-ring" style="width:240px;height:240px;bottom:-60px;right:12%;--bo:0.05;"></span>
        <span class="mp-ring" style="width:160px;height:160px;top:22%;left:32%;--bo:0.06;"></span>
        <span class="mp-ring" style="width:90px;height:90px;top:65%;right:22%;--bo:0.09;"></span>

        {{-- Persegi miring halus --}}
        <span class="mp-rect" style="width:80px;height:80px;top:18%;left:8%;--r:20deg;--o:0.04;"></span>
        <span class="mp-rect" style="width:50px;height:50px;top:60%;right:10%;--r:-15deg;--o:0.05;"></span>
        <span class="mp-rect" style="width:120px;height:40px;top:80%;left:55%;--r:30deg;--o:0.04;"></span>
        <span class="mp-rect" style="width:60px;height:60px;top:8%;left:60%;--r:45deg;--o:0.04;"></span>

        {{-- Garis diagonal panjang --}}
        <span class="mp-line" style="width:600px;top:28%;left:-50px;--r:-18deg;"></span>
        <span class="mp-line" style="width:400px;top:62%;right:0;--r:-22deg;"></span>
        <span class="mp-line" style="width:300px;top:45%;left:30%;--r:12deg;"></span>

        {{-- Dot grid kecil di pojok --}}
        <span class="mp-dotgrid" style="width:180px;height:180px;top:5%;right:5%;--o:0.45;"></span>
        <span class="mp-dotgrid" style="width:140px;height:140px;bottom:8%;left:4%;--o:0.40;"></span>

    </div>

    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('login') }}" class="navbar-brand" title="Login Admin PT SUMBERINDO FARMA TAMA">
                <img src="{{ asset('logo pt sumber indo farma tama.png') }}" alt="Sumberindo Farma Logo">
                PT SUMBERINDO FARMA TAMA
            </a>
            
            <!-- Hamburger Menu Button -->
            <button class="hamburger-menu" id="hamburgerBtn">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="navbar-menu" id="navbarMenu">
                <li><a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Home</a></li>
                <li><a href="{{ route('about') }}"><i class="fa-solid fa-circle-info"></i> Tentang Kami</a></li>
                <li><a href="{{ route('contact') }}"><i class="fa-solid fa-headset"></i> Hubungi Kami</a></li>
                <li><a href="{{ route('partners') }}"><i class="fa-solid fa-handshake"></i> Mitra Kami</a></li>

                @auth
                    @if(auth()->user()->isAdmin())
                        <li><a href="{{ route('admin.dashboard') }}" class="admin-link"><i class="fa-solid fa-gauge"></i> Admin Panel</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                            </form>
                        </li>
                    @elseif(auth()->user()->isUser())
                        <li>
                            <form action="{{ route('customer.logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="logout-btn">
                                    <i class="fa-solid fa-right-from-bracket"></i> Logout ({{ auth()->user()->name }})
                                </button>
                            </form>
                        </li>
                    @endif
                @endauth
            </ul>

            {{-- Cart button --}}
            @if(Route::is(['products.*', 'medicines.show']))
                <button class="cart-nav-btn" id="cartNavBtn" onclick="if(typeof openCart==='function'){openCart();}else{window.location.href='{{ route('products.apotek') }}#keranjang';}" title="Keranjang Belanja" style="display:none;">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-badge" id="cartBadgeNav">0</span>
                </button>
            @endif
        </div>
    </nav>

    <!-- Content -->
    <main class="page-offset">
        <!-- Alert Messages -->
        @if ($message = Session::get('success'))
            <div class="container" style="padding-top:0.75rem;">
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="container" style="padding-top:0.75rem;">
                <div class="alert alert-error">
                    {{ $message }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div>
                    <h3><i class="fa-solid fa-pills"></i> Sumberindo Farma Tama</h3>
                    <p>Perusahaan distribusi farmasi (PBF) yang menyediakan produk resmi untuk apotek dan fasilitas kesehatan.</p>
                </div>
                <div>
                    <h3>Informasi</h3>
                    <ul>
                        <li><a href="{{ route('contact') }}"><i class="fa-solid fa-headset fa-fw footer-icon"></i>Hubungi Kami</a></li>
                        <li><a href="#"><i class="fa-solid fa-shield-halved fa-fw footer-icon"></i>Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div>
                    <h3>Kontak</h3>
                    <ul>
                        <li>
                            <a href="tel:+6285248965590"><i class="fa-solid fa-phone footer-icon"></i>+62 852-4896-5590</a>
                        </li>
                        <li>
                            <a href="mailto:pt.sumberindofarmatama@sumberindopontianak.com"><i class="fa-solid fa-envelope footer-icon"></i>pt.sumberindofarmatama@sumberindopontianak.com</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Sumberindo Farma Tama. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Floating Buttons -->
    <style>
        .float-wrap { position:fixed; bottom:1.75rem; right:1.75rem; display:flex; flex-direction:column; align-items:center; gap:0; z-index:999; }

        /* Links container desktop */
        .float-links {
            display:flex; flex-direction:column; align-items:center; gap:0.9rem;
        }

        .float-item { position:relative; display:flex; align-items:center; justify-content:center; }
        .float-tooltip { display:none; }
        .float-label-mobile { display:none; }

        .float-btn {
            width:38px; height:38px; border-radius:50%; display:flex; align-items:center; justify-content:center;
            text-decoration:none; transition:transform 0.2s, box-shadow 0.2s; flex-shrink:0;
            font-size:1.1rem;
        }
        .float-btn:hover { transform:scale(1.13); }

        /* WhatsApp lebih besar */
        .float-btn-wa {
            width:60px !important; height:60px !important; font-size:1.85rem !important;
            margin-top:0.6rem;
        }

        /* Toggle button (mobile only) */
        .float-toggle {
            width:50px; height:50px; border-radius:50%; background:linear-gradient(135deg,#991B1B,#B91C1C);
            border:none; color:white; font-size:1.3rem; cursor:pointer;
            display:none; align-items:center; justify-content:center;
            box-shadow:0 4px 16px rgba(13,71,161,0.45); transition:transform 0.3s;
            flex-shrink:0;
        }
        .float-toggle.open { transform:rotate(45deg); }

        /* Mobile */
        @media (max-width: 768px) {
            .float-links {
                display:flex; flex-direction:column; align-items:flex-end; gap:0.75rem;
                overflow:hidden; max-height:0; transition:max-height 0.45s ease, opacity 0.35s;
                opacity:0; pointer-events:none;
            }
            .float-links.open {
                max-height:600px; opacity:1; pointer-events:auto;
            }
            .float-wrap { gap:0.6rem; align-items:flex-end; }
            .float-btn { width:50px !important; height:50px !important; font-size:1.4rem !important; }
            .float-btn-wa { width:50px !important; height:50px !important; font-size:1.6rem !important; margin-top:0; }
            .float-toggle { display:flex; }
            .float-item { gap:0.5rem; flex-direction:row; align-items:center; }
            .float-label-mobile {
                background:#1f2937; color:white; font-size:0.72rem; font-weight:600;
                padding:0.25rem 0.6rem; border-radius:8px; white-space:nowrap;
                display:none;
            }
            .float-links.open .float-label-mobile { display:block; }
        }
    </style>

    <div class="float-wrap">
        <!-- Links (semua tombol) -->
        <div class="float-links" id="floatLinks">
            <!-- Instagram -->
            <div class="float-item">
                <span class="float-tooltip">Instagram</span>
                <span class="float-label-mobile">Instagram</span>
                <a href="https://www.instagram.com/sumberindofarma?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="float-btn"
                   style="background:linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);color:white;font-size:1.4rem;box-shadow:0 4px 16px rgba(220,39,67,0.45);">
                    <i class="fa-brands fa-instagram"></i>
                </a>
            </div>

            <!-- TikTok -->
            <div class="float-item">
                <span class="float-tooltip">TikTok</span>
                <span class="float-label-mobile">TikTok</span>
                <a href="https://www.tiktok.com/@ptsumberindofarmatama" target="_blank" class="float-btn"
                   style="background:#000;color:white;box-shadow:0 4px 16px rgba(0,0,0,0.25);display:flex;align-items:center;justify-content:center;">
                    <div style="width:24px;height:24px;background:white;border-radius:6px;display:flex;align-items:center;justify-content:center;"><img src="{{ asset('logo tiktok.avif') }}" alt="TikTok" style="width:20px;height:20px;object-fit:cover;border-radius:4px;"></div>
                </a>
            </div>

            <!-- Shopee -->
            <div class="float-item">
                <span class="float-tooltip">Shopee</span>
                <span class="float-label-mobile">Shopee</span>
                <a href="#" class="float-btn"
                   style="background:#EE3131;color:white;box-shadow:0 4px 16px rgba(238,49,49,0.25);display:flex;align-items:center;justify-content:center;">
                    <div style="width:24px;height:24px;background:white;border-radius:6px;display:flex;align-items:center;justify-content:center;"><img src="{{ asset('logoshopee.jpeg') }}" alt="Shopee" style="width:20px;height:20px;object-fit:cover;border-radius:4px;"></div>
                </a>
            </div>

            <!-- WhatsApp -->
            <div class="float-item">
                <span class="float-tooltip">Chat WhatsApp</span>
                <span class="float-label-mobile">WhatsApp</span>
                <a href="https://wa.me/6285248965590?text=Halo%20Sumberindo%20Farma%20Tama%2C%20saya%20ingin%20bertanya%20tentang%20produk%20obat."
                   target="_blank" class="float-btn float-btn-wa"
                   style="background:#25D366;color:white;font-size:1.9rem;box-shadow:0 6px 24px rgba(37,211,102,0.55);">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
            </div>
        </div>

        <!-- Toggle button (mobile only) -->
        <button class="float-toggle" id="floatToggle" onclick="toggleFloat()">
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>

    <script>
        function toggleFloat() {
            const links  = document.getElementById('floatLinks');
            const toggle = document.getElementById('floatToggle');
            links.classList.toggle('open');
            toggle.classList.toggle('open');
        }
        // Desktop: selalu tampil - jangan pakai inline style agar tidak override CSS
        function checkFloatDesktop() {
            const links = document.getElementById('floatLinks');
            if (window.innerWidth > 768) {
                // Hapus semua inline style supaya CSS desktop berlaku
                links.style.maxHeight = '';
                links.style.opacity   = '';
                links.style.overflow  = '';
                links.style.display   = '';
                links.classList.remove('open');
            } else {
                // Mobile: biarkan CSS yang mengatur via class .open
                links.style.maxHeight = '';
                links.style.opacity   = '';
                links.style.overflow  = '';
                links.style.display   = '';
            }
        }
        checkFloatDesktop();
        window.addEventListener('resize', checkFloatDesktop);
    </script>

    <script>
        window.cartSettings = Object.assign({
            storageKey: @json(auth()->check() ? 'sumberindofarmatama_cart_user_' . auth()->user()->id : 'sumberindofarmatama_cart')
        }, window.cartSettings || {});
    </script>

    @yield('scripts')

    <script>
        // ===== SMOOTH SCROLL =====
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // ===== SCROLL REVEAL =====
        const revealStyle = document.createElement('style');
        revealStyle.textContent = `
            .reveal {
                opacity: 0;
                transform: translateY(32px);
                transition: opacity 0.6s ease, transform 0.6s ease;
            }
            .reveal.visible {
                opacity: 1;
                transform: translateY(0);
            }
            .reveal-left {
                opacity: 0;
                transform: translateX(-40px);
                transition: opacity 0.6s ease, transform 0.6s ease;
            }
            .reveal-left.visible {
                opacity: 1;
                transform: translateX(0);
            }
            .reveal-right {
                opacity: 0;
                transform: translateX(40px);
                transition: opacity 0.6s ease, transform 0.6s ease;
            }
            .reveal-right.visible {
                opacity: 1;
                transform: translateX(0);
            }
            .reveal-scale {
                opacity: 0;
                transform: scale(0.92);
                transition: opacity 0.55s ease, transform 0.55s ease;
            }
            .reveal-scale.visible {
                opacity: 1;
                transform: scale(1);
            }
        `;
        document.head.appendChild(revealStyle);

        // Auto-tag elemen yang perlu dianimasikan
        function tagRevealElements() {
            const selectors = [
                // Cards
                '.feature-card', '.medicine-card', '.news-preview-card',
                '.news-card', '.value-card', '.team-card', '.related-card',
                '.vm-card', '.stat-card',
                // Sections & blocks
                '.about-section', '.about-text', '.about-image-stack',
                '.price-section', '.description-section',
                '.detail-container > .detail-grid',
                '.related-section',
                // Stats bar items
                '.stat-item',
                // Footer columns
                '.footer-content > div',
            ];

            selectors.forEach(sel => {
                document.querySelectorAll(sel).forEach((el, i) => {
                    if (!el.classList.contains('reveal') &&
                        !el.classList.contains('reveal-left') &&
                        !el.classList.contains('reveal-right') &&
                        !el.classList.contains('reveal-scale')) {
                        el.classList.add('reveal');
                        // Stagger delay untuk grid items
                        el.style.transitionDelay = (i % 4) * 0.1 + 's';
                    }
                });
            });

            // Kolom kiri/kanan di row Bootstrap
            document.querySelectorAll('.row > .col-lg-5, .row > .col-md-5').forEach(el => {
                if (!el.querySelector('.reveal-left') && !el.classList.contains('reveal-left')) {
                    el.classList.add('reveal-left');
                }
            });
            document.querySelectorAll('.row > .col-lg-7, .row > .col-md-7').forEach(el => {
                if (!el.classList.contains('reveal-right')) {
                    el.classList.add('reveal-right');
                }
            });
        }

        // IntersectionObserver untuk trigger animasi
        function initObserver() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

            document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale')
                .forEach(el => observer.observe(el));
        }

        // Jalankan setelah DOM siap
        document.addEventListener('DOMContentLoaded', () => {
            tagRevealElements();
            initObserver();
        });

        // Fallback jika DOMContentLoaded sudah lewat
        if (document.readyState !== 'loading') {
            tagRevealElements();
            initObserver();
        }
    </script>

    <script>
        // Cart badge sync - hanya tampilkan jika halaman benar-benar memiliki cart partial
        (function() {
            if (!window.hasProductCart) {
                return;
            }

            // Migrasi sekali: jika ada key lama retail/grosir, gabungkan ke key utama
            ['sumberindofarmatama_cart_retail', 'sumberindofarmatama_cart_grosir'].forEach(function(oldKey) {
                try {
                    const oldData = JSON.parse(localStorage.getItem(oldKey) || '[]');
                    if (oldData.length) {
                        let current = JSON.parse(localStorage.getItem('sumberindofarmatama_cart') || '[]');
                        oldData.forEach(function(item) {
                            const ex = current.find(function(i) { return i.id === item.id; });
                            if (ex) ex.qty += item.qty; else current.push(item);
                        });
                        localStorage.setItem('sumberindofarmatama_cart', JSON.stringify(current));
                        localStorage.removeItem(oldKey);
                    }
                } catch(e) {}
            });

            const defaultPathKey = 'sumberindofarmatama_cart_' + window.location.pathname.toLowerCase().replace(/[^a-z0-9]+/g, '_');
            const storageKey = (window.cartSettings && window.cartSettings.storageKey)
                ? window.cartSettings.storageKey
                : defaultPathKey;
            const cart = JSON.parse(localStorage.getItem(storageKey) || '[]');
            const total = cart.reduce(function(s, i) { return s + i.qty; }, 0);
            
            const badge = document.getElementById('cartBadgeNav');
            const btn   = document.getElementById('cartNavBtn');
            if (badge) { badge.textContent = total; badge.style.display = total > 0 ? 'flex' : 'none'; }
            if (btn) btn.style.display = total > 0 ? 'flex' : 'none';
        })();

        // Hamburger Menu Toggle
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const navbarMenu = document.getElementById('navbarMenu');

        function setNavbarHeight() {
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                document.documentElement.style.setProperty('--navbar-height', navbar.offsetHeight + 'px');
            }
        }
        setNavbarHeight();
        window.addEventListener('DOMContentLoaded', setNavbarHeight);
        window.addEventListener('load', setNavbarHeight);
        window.addEventListener('resize', setNavbarHeight);

        hamburgerBtn.addEventListener('click', () => {
            setNavbarHeight();
            hamburgerBtn.classList.toggle('active');
            navbarMenu.classList.toggle('active');
        });

        // Close menu when clicking on a link
        const menuLinks = navbarMenu.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                hamburgerBtn.classList.remove('active');
                navbarMenu.classList.remove('active');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.navbar')) {
                hamburgerBtn.classList.remove('active');
                navbarMenu.classList.remove('active');
            }
        });
    </script>
    
    <!-- Fix Cursor Script -->
    <script src="{{ asset('js/fix-cursor-override.js') }}"></script>
    <script src="{{ asset('js/fix-cursor.js') }}"></script>
</body>
</html>





