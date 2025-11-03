<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <style>
        :root {
            --header-h: 56px;
            --footer-h: 24px;
        }

        body {
            overflow: hidden;
            background: #f6f8fb;
        }

        .app {
            display: grid;
            grid-template-columns: 260px 1fr;
            grid-template-rows: auto 1fr auto;
            grid-template-areas:
                "sidebar header"
                "sidebar main"
                "sidebar footer";
            height: 100vh;
            transition: grid-template-columns 0.3s ease;
            position: relative;
        }

        .sidebar {
            background: #2c3e50;
            color: #fff;
            position: relative;
            top: 0;
            left: 0;
            height: 100vh;
            overflow: hidden; /* Changed to hidden to control scroll in nav section */
            transition: width 0.3s ease, transform .25s ease;
            will-change: transform, width;
            width: 260px;
            grid-area: sidebar;
            z-index: 1030;
            display: flex;
            flex-direction: column;
        }

        .sidebar a {
            color: #cfe0ff;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, .08);
        }

        .app-header {
            grid-area: header;
            z-index: 1030;
            position: relative;
        }

        .app-footer {
            grid-area: footer;
            z-index: 1;
            position: relative;
        }

        .content {
            overflow: auto;
            background: #f6f8fb;
            height: auto;
            padding-bottom: 1rem;
            grid-area: main;
            z-index: 10;
            position: relative;
        }

        /* Sidebar header with toggle button */
        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 0.5rem 0;
            margin-bottom: 1rem;
            padding-left: 0.5rem;
        }

        .brand {
            font-weight: 600;
            letter-spacing: .3px;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
        }

        .sidebar-toggle-inside {
            background: rgba(255, 255, 255, .1);
            border: none;
            color: #fff;
            padding: 0.375rem 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
            cursor: pointer;
            flex-shrink: 0;
        }

        .sidebar-toggle-inside:hover {
            background: rgba(255, 255, 255, .2);
        }

        .sidebar-toggle-inside i {
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            flex-shrink: 0; /* Don't shrink header */
        }

        .sidebar-nav-container {
            flex: 1; /* Take remaining space */
            overflow-y: auto; /* Make scrollable */
            overflow-x: hidden;
            padding-bottom: 1rem;
        }

        .sidebar-nav-container::-webkit-scrollbar {
            width: 0px; /* Hide scrollbar */
            background: transparent;
        }

        .sidebar-nav-container::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav-container::-webkit-scrollbar-thumb {
            background: transparent;
        }

        /* For Firefox */
        .sidebar-nav-container {
            scrollbar-width: none; /* Hide scrollbar */
        }

        .profile {
            flex-shrink: 0; /* Don't shrink profile */
            padding: 0.5rem 0.75rem;
            border-top: 1px solid rgba(255, 255, 255, .1);
            height: 50px;
            z-index: 1000; /* Higher z-index than menu items */
            background: #2c3e50; /* Ensure background covers menu items */
            display: flex;
            align-items: center;
        }

        .profile .dropdown-menu {
            position: absolute !important;
            inset: auto auto 50px 0 !important;
            transition: all 0.3s ease;
            z-index: 1001; /* Even higher for dropdown */
        }

        /* Label transitions */
        .label {
            opacity: 1;
            transition: opacity 0.2s ease;
            display: inline-block;
            white-space: nowrap;
        }

        /* Collapsible behavior */
        .toggle-btn {
            position: fixed;
            top: 14px;
            left: 14px;
            z-index: 1030;
            transition: all 0.3s ease;
        }

        /* MOBILE FIXES - CRITICAL */
        @media (max-width: 991.98px) {

            /* Prevent body scroll on mobile to fix sidebar issue */
            body {
                overflow: hidden !important;
                position: fixed !important;
                width: 100% !important;
                height: 100vh !important;
                height: 100dvh !important;
            }

            .app {
                grid-template-columns: 1fr;
                grid-template-areas:
                    "header"
                    "main"
                    "footer";
                height: 100vh !important;
                height: 100dvh !important;
                overflow: hidden;
            }

            .sidebar {
                position: fixed !important;
                width: 260px;
                z-index: 1029;
                left: 0;
                top: 0 !important;
                bottom: 0;
                transform: translateX(-100%);
                height: 100vh !important;
                height: 100dvh !important;
                /* Dynamic viewport height for mobile browsers */
                overflow: hidden; /* Keep consistent with desktop */
                display: flex;
                flex-direction: column;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .toggle-btn {
                display: none !important;
            }

            .content {
                grid-column: 1 / -1;
                overflow-y: auto !important;
                overflow-x: hidden !important;
                height: 100vh !important;
                height: 100dvh !important;
                width: 100%;
                padding: 1rem 1rem 1rem 1rem !important;
                -webkit-overflow-scrolling: touch;
                /* Smooth scrolling on iOS */
            }

            .sidebar-backdrop {
                content: "";
                position: fixed !important;
                inset: 0 !important;
                background: rgba(0, 0, 0, .35);
                z-index: 1028;
                opacity: 0;
                visibility: hidden;
                transition: opacity .25s ease;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                height: 100vh !important;
                height: 100dvh !important;
            }

            .sidebar-backdrop.show {
                opacity: 1;
                visibility: visible;
            }
        }

        /* Desktop collapsed state */
        @media (min-width: 992px) {
            .collapsed .app {
                grid-template-columns: 72px 1fr;
            }

            .collapsed .sidebar {
                width: 72px;
            }

            .collapsed .sidebar .sidebar-nav-container {
                overflow: hidden; /* Hide scrollbar when collapsed */
            }

            .collapsed .sidebar .label {
                opacity: 0;
                width: 0;
                overflow: hidden;
            }

            .collapsed .sidebar .nav-link i {
                margin-right: 0 !important;
            }

            .collapsed .sidebar .brand .label {
                opacity: 0;
            }

            .collapsed .sidebar .brand i {
                margin-right: 0 !important;
            }

            .collapsed .sidebar [data-bs-toggle="collapse"]::after {
                content: none !important;
            }

            /* Rotate toggle button icon when collapsed */
            .collapsed .sidebar-toggle-inside i {
                transform: rotate(180deg);
            }

            /* Center sidebar header content */
            .collapsed .sidebar-header {
                justify-content: center;
                padding-left: 0;
            }

            .collapsed .sidebar-header .brand {
                display: none;
            }

            /* Fix Invoice Items Table Alignment - PC & Mobile */
            #itemsTable {
                table-layout: fixed;
                width: 100%;
                min-width: 1800px;
                /* Force minimum width */
            }

            #itemsTable thead th {
                vertical-align: middle;
                text-align: center;
                white-space: nowrap;
                /* Prevent text wrapping */
                padding: 12px 8px;
                font-weight: 600;
                font-size: 0.875rem;
                position: sticky;
                top: 0;
                background-color: #f8f9fa;
                z-index: 10;
            }

            #itemsTable tbody td {
                vertical-align: middle;
                padding: 8px 5px;
            }

            /* Column widths */
            #itemsTable th:nth-child(1),
            #itemsTable td:nth-child(1) {
                width: 80px;
            }

            #itemsTable th:nth-child(2),
            #itemsTable td:nth-child(2) {
                width: 150px;
            }

            #itemsTable th:nth-child(3),
            #itemsTable td:nth-child(3) {
                width: 120px;
            }

            #itemsTable th:nth-child(4),
            #itemsTable td:nth-child(4) {
                width: 90px;
            }

            #itemsTable th:nth-child(5),
            #itemsTable td:nth-child(5) {
                width: 80px;
            }

            #itemsTable th:nth-child(6),
            #itemsTable td:nth-child(6) {
                width: 110px;
            }

            #itemsTable th:nth-child(7),
            #itemsTable td:nth-child(7) {
                width: 70px;
            }

            #itemsTable th:nth-child(8),
            #itemsTable td:nth-child(8) {
                width: 70px;
            }

            #itemsTable th:nth-child(9),
            #itemsTable td:nth-child(9) {
                width: 70px;
            }

            #itemsTable th:nth-child(10),
            #itemsTable td:nth-child(10) {
                width: 80px;
            }

            #itemsTable th:nth-child(11),
            #itemsTable td:nth-child(11) {
                width: 90px;
            }

            #itemsTable th:nth-child(12),
            #itemsTable td:nth-child(12) {
                width: 80px;
            }

            #itemsTable th:nth-child(13),
            #itemsTable td:nth-child(13) {
                width: 80px;
            }

            #itemsTable th:nth-child(14),
            #itemsTable td:nth-child(14) {
                width: 100px;
            }

            #itemsTable th:nth-child(15),
            #itemsTable td:nth-child(15) {
                width: 60px;
                text-align: center;
            }

            /* Make inputs fit */
            #itemsTable input.form-control,
            #itemsTable select.form-select {
                width: 100%;
                font-size: 0.875rem;
                padding: 0.375rem 0.5rem;
            }

            /* Select2 fix */
            #itemsTable .select2-container {
                width: 100% !important;
            }

            #itemsTable .select2-selection {
                min-height: 36px !important;
            }

            .table-responsive {
                overflow-x: auto !important;
                overflow-y: visible;
                -webkit-overflow-scrolling: touch;
                display: block;
                width: 100%;
            }

            /* Mobile specific adjustments */
            @media (max-width: 768px) {
                #itemsTable {
                    min-width: 1800px !important;
                    /* Keep table wide */
                    font-size: 0.75rem;
                }

                #itemsTable thead th {
                    font-size: 0.7rem !important;
                    padding: 8px 5px !important;
                    white-space: nowrap !important;
                    /* Force single line - NO WRAPPING */
                    line-height: 1.2 !important;
                    height: auto !important;
                }

                #itemsTable tbody td {
                    padding: 5px 3px !important;
                    white-space: nowrap !important;
                }

                #itemsTable input.form-control,
                #itemsTable select.form-select {
                    font-size: 0.7rem !important;
                    padding: 0.25rem 0.3rem !important;
                    height: 30px !important;
                    min-height: 30px !important;
                }

                #itemsTable .select2-container .select2-selection {
                    min-height: 30px !important;
                    height: 30px !important;
                    font-size: 0.7rem !important;
                }

                #itemsTable .select2-container .select2-selection__rendered {
                    line-height: 28px !important;
                    padding-left: 5px !important;
                }

                #itemsTable .select2-container .select2-selection__arrow {
                    height: 28px !important;
                }

                /* Compact column widths for mobile */
                #itemsTable th:nth-child(1),
                #itemsTable td:nth-child(1) {
                    width: 70px !important;
                }

                #itemsTable th:nth-child(2),
                #itemsTable td:nth-child(2) {
                    width: 130px !important;
                }

                #itemsTable th:nth-child(3),
                #itemsTable td:nth-child(3) {
                    width: 110px !important;
                }

                #itemsTable th:nth-child(4),
                #itemsTable td:nth-child(4) {
                    width: 80px !important;
                }

                #itemsTable th:nth-child(5),
                #itemsTable td:nth-child(5) {
                    width: 70px !important;
                }

                #itemsTable th:nth-child(6),
                #itemsTable td:nth-child(6) {
                    width: 100px !important;
                }

                #itemsTable th:nth-child(7),
                #itemsTable td:nth-child(7) {
                    width: 60px !important;
                }

                #itemsTable th:nth-child(8),
                #itemsTable td:nth-child(8) {
                    width: 60px !important;
                }

                #itemsTable th:nth-child(9),
                #itemsTable td:nth-child(9) {
                    width: 60px !important;
                }

                #itemsTable th:nth-child(10),
                #itemsTable td:nth-child(10) {
                    width: 70px !important;
                }

                #itemsTable th:nth-child(11),
                #itemsTable td:nth-child(11) {
                    width: 80px !important;
                }

                #itemsTable th:nth-child(12),
                #itemsTable td:nth-child(12) {
                    width: 70px !important;
                }

                #itemsTable th:nth-child(13),
                #itemsTable td:nth-child(13) {
                    width: 70px !important;
                }

                #itemsTable th:nth-child(14),
                #itemsTable td:nth-child(14) {
                    width: 90px !important;
                }

                #itemsTable th:nth-child(15),
                #itemsTable td:nth-child(15) {
                    width: 50px !important;
                }

                /* Remove extra spacing */
                .card-body {
                    padding: 0.75rem !important;
                }
            }

            /* Extra small devices */
            @media (max-width: 576px) {
                #itemsTable {
                    min-width: 1600px !important;
                }

                #itemsTable thead th {
                    font-size: 0.65rem !important;
                    padding: 6px 4px !important;
                }

                #itemsTable input.form-control,
                #itemsTable select.form-select {
                    font-size: 0.65rem !important;
                    padding: 0.2rem 0.25rem !important;
                    height: 28px !important;
                }
            }

            /* Profile button in collapsed state */
            .collapsed .profile .btn {
                justify-content: center;
                padding: 0.5rem;
            }

            .collapsed .profile .btn img {
                margin: 0 !important;
            }

            .collapsed .profile .btn .flex-grow-1,
            .collapsed .profile .btn .bi-chevron-up {
                display: none !important;
            }

            /* Profile dropdown positioning in collapsed state */
            .collapsed .profile .dropdown-menu {
                left: 72px !important;
                bottom: 0 !important;
                min-width: 200px !important;
                inset: auto auto 0 72px !important;
            }

            /* Collapse button icons */
            .collapsed .sidebar .collapse {
                display: none !important;
            }

            .collapsed .sidebar [data-bs-toggle="collapse"] {
                justify-content: center !important;
                padding: 0.5rem !important;
            }

            .collapsed .sidebar [data-bs-toggle="collapse"] i {
                margin: 0 !important;
            }

            /* Remove Bootstrap focus glow globally */
            *:focus,
            input:focus,
            select:focus,
            textarea:focus,
            button:focus,
            .form-control:focus,
            .form-select:focus,
            .btn:focus {
                box-shadow: none !important;
                outline: none !important;
            }

            /* Keep border color normal */
            .form-control:focus,
            .form-select:focus {
                border-color: #dee2e6 !important;
            }

            /* Select2 fix */
            .select2-container--bootstrap-5 .select2-selection:focus,
            .select2-container--bootstrap-5.select2-container--focus .select2-selection,
            .select2-container--bootstrap-5.select2-container--open .select2-selection,
            .select2-selection:focus,
            .select2-selection--single:focus {
                box-shadow: none !important;
                outline: none !important;
                border-color: #dee2e6 !important;
            }

            /* Center align nav items when collapsed */
            .collapsed .sidebar .nav-link {
                justify-content: center;
                padding: 0.5rem !important;
                pointer-events: none;
                cursor: not-allowed;
                opacity: 0.6;
            }

            /* Prevent clicking on menu buttons when collapsed */
            .collapsed .sidebar [data-bs-toggle="collapse"] {
                pointer-events: none;
                cursor: not-allowed;
                opacity: 0.6;
            }

            /* Only allow toggle button to work */
            .collapsed .sidebar-toggle-inside {
                pointer-events: auto;
                cursor: pointer;
                opacity: 1;
            }
        }

        /* Smooth icon transitions */
        .sidebar i {
            transition: margin 0.3s ease;
        }

        /* Button styling improvements */
        [data-bs-toggle="collapse"] {
            border: none;
            transition: all 0.2s ease;
        }

        [data-bs-toggle="collapse"]:hover {
            background: rgba(255, 255, 255, .08) !important;
        }

        .sidebar [data-bs-toggle="collapse"]::after {
            content: "+";
            margin-left: auto;
            color: #cfe0ff;
            font-weight: 700;
            line-height: 1;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        .sidebar [data-bs-toggle="collapse"][aria-expanded="true"]::after {
            content: "−";
        }

        .sidebar [data-bs-toggle="collapse"][aria-expanded="true"]::after {
            transform: scale(1.05);
            opacity: 1;
        }

        .sidebar [data-bs-toggle="collapse"][aria-expanded="false"]::after {
            transform: scale(1);
            opacity: 0.9;
        }

        /* Global Scroll to Top Button - Fixed positioning */
        #scrollToTop {
            position: fixed !important;
            bottom: 30px !important;
            right: 30px !important;
            z-index: 10000 !important;
            border-radius: 50% !important;
            width: 50px !important;
            height: 50px !important;
            background: #0d6efd !important;
            color: #fff !important;
            border: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
            padding: 0 !important;
            margin: 0 !important;
            line-height: 1 !important;
        }

        #scrollToTop:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2) !important;
            background: #0b5ed7 !important;
        }

        #scrollToTop:active {
            transform: translateY(-1px) !important;
        }

        #scrollToTop i {
            font-size: 22px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Show state for scroll to top button */
        #scrollToTop.show {
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
        }

        #scrollToTop.hide {
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
        }

        .app-footer .py-3 {
            padding-top: 12px !important;
            padding-bottom: 12px !important;
        }

         .app-header .py-3 {
            padding-top: 11px !important;
            padding-bottom: 11px !important;
        }
    </style>
    @stack('styles')
    @vite(['resources/js/app.js'])
    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>
    <div class="app">
        @include('layouts.header')
        <aside class="sidebar p-3 position-relative">
            <div class="sidebar-header">
                <div class="brand d-flex align-items-center small">
                    <i class="bi bi-ui-checks-grid me-2 text-info"></i>
                    <span class="label">InvoiceLab</span>
                </div>
            </div>

            <div class="sidebar-nav-container">
                <nav class="nav flex-column small">
                <a class="nav-link text-white d-flex align-items-center px-2" href="/admin/dashboard">
                    <i class="bi bi-speedometer2 me-2"></i><span class="label">Dashboard</span>
                </a>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuCompanies" aria-expanded="false"
                        style="background:transparent;">
                        <i class="bi bi-buildings me-2"></i> <span class="label">Companies</span>
                    </button>
                    <div class="collapse" id="menuCompanies"><a class="nav-link ms-3 d-flex align-items-center"
                            href="{{ route('admin.companies.create') }}">
                            <span class="label">Add Company</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.companies.index') }}">
                            <span class="label">All Companies</span>
                        </a>

                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuCustomers" style="background:transparent;">
                        <i class="bi bi-people me-2"></i> <span class="label">Customers</span>
                    </button>
                    <div class="collapse" id="menuCustomers"><a class="nav-link ms-3 d-flex align-items-center"
                            href="{{ route('admin.customers.create') }}">
                            <span class="label">Add Customer</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.customers.index') }}">
                            <span class="label">All Customers</span>
                        </a>

                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuItems" style="background:transparent;">
                        <i class="bi bi-box-seam me-2"></i> <span class="label">Items</span>
                    </button>
                    <div class="collapse" id="menuItems"><a class="nav-link ms-3 d-flex align-items-center"
                            href="{{ route('admin.items.create') }}">
                            <span class="label">Add Item</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.items.index') }}">
                            <span class="label">All Items</span>
                        </a>

                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuSuppliers" style="background:transparent;">
                        <i class="bi bi-truck me-2"></i> <span class="label">Suppliers</span>
                    </button>
                    <div class="collapse" id="menuSuppliers">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.suppliers.create') }}">
                            <span class="label">Add Supplier</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.suppliers.index') }}">
                            <span class="label">All Suppliers</span>
                        </a>

                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuHsnCodes" style="background:transparent;">
                        <i class="bi bi-upc-scan me-2"></i> <span class="label">HSN Master</span>
                    </button>
                    <div class="collapse" id="menuHsnCodes">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.hsn-codes.create') }}">
                            <span class="label">Add HSN Code</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.hsn-codes.index') }}">
                            <span class="label">All HSN Codes</span>
                        </a>

                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuInvoices" style="background:transparent;">
                        <i class="bi bi-receipt-cutoff me-2"></i> <span class="label">Invoices</span>
                    </button>
                    <div class="collapse" id="menuInvoices">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.invoices.create') }}">
                            <span class="label">Add Invoice</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.invoices.index') }}">
                            <span class="label">All Invoices</span>
                        </a>

                    </div>
                </div>

                <div class="mt-2">
                    <a class="nav-link text-white d-flex align-items-center px-2" href="/admin/all-ledger">
                        <i class="bi bi-journal-check me-2"></i><span class="label">All Ledger</span>
                    </a>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuGeneralLedger" style="background:transparent;">
                        <i class="bi bi-journal-text me-2"></i> <span class="label">General Ledger</span>
                    </button>
                    <div class="collapse" id="menuGeneralLedger">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.general-ledger.create') }}">
                            <span class="label">Add Account</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.general-ledger.index') }}">
                            <span class="label">All Accounts</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuCashBank" style="background:transparent;">
                        <i class="bi bi-cash-stack me-2"></i> <span class="label">Cash / Bank Books</span>
                    </button>
                    <div class="collapse" id="menuCashBank">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.cash-bank-books.create') }}">
                            <span class="label">Add Transaction</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.cash-bank-books.index') }}">
                            <span class="label">All Transactions</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuSaleLedger" style="background:transparent;">
                        <i class="bi bi-cart-check me-2"></i> <span class="label">Sale Ledger</span>
                    </button>
                    <div class="collapse" id="menuSaleLedger">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.sale-ledger.create') }}">
                            <span class="label">Add Sale Entry</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.sale-ledger.index') }}">
                            <span class="label">All Sale Entries</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuPurchaseLedger" style="background:transparent;">
                        <i class="bi bi-bag-check me-2"></i> <span class="label">Purchase Ledger</span>
                    </button>
                    <div class="collapse" id="menuPurchaseLedger">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.purchase-ledger.create') }}">
                            <span class="label">Add Purchase Entry</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.purchase-ledger.index') }}">
                            <span class="label">All Purchase Entries</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuSalesMen" style="background:transparent;">
                        <i class="bi bi-person-badge me-2"></i> <span class="label">Sales Man</span>
                    </button>
                    <div class="collapse" id="menuSalesMen">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.sales-men.create') }}">
                            <span class="label">Add Sales Man</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.sales-men.index') }}">
                            <span class="label">All Sales Men</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuAreas" style="background:transparent;">
                        <i class="bi bi-geo-alt me-2"></i> <span class="label">Area</span>
                    </button>
                    <div class="collapse" id="menuAreas">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.areas.create') }}">
                            <span class="label">Add Area</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.areas.index') }}">
                            <span class="label">All Areas</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuRoutes" style="background:transparent;">
                        <i class="bi bi-signpost me-2"></i> <span class="label">Route</span>
                    </button>
                    <div class="collapse" id="menuRoutes">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.routes.create') }}">
                            <span class="label">Add Route</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.routes.index') }}">
                            <span class="label">All Routes</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuStates" style="background:transparent;">
                        <i class="bi bi-map me-2"></i> <span class="label">State</span>
                    </button>
                    <div class="collapse" id="menuStates">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.states.create') }}">
                            <span class="label">Add State</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.states.index') }}">
                            <span class="label">All States</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuAreaManagers" style="background:transparent;">
                        <i class="bi bi-person-workspace me-2"></i> <span class="label">Area Mgr.</span>
                    </button>
                    <div class="collapse" id="menuAreaManagers">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.area-managers.create') }}">
                            <span class="label">Add Area Manager</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.area-managers.index') }}">
                            <span class="label">All Area Managers</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuRegionalManagers" style="background:transparent;">
                        <i class="bi bi-people-fill me-2"></i> <span class="label">Regn.mgr</span>
                    </button>
                    <div class="collapse" id="menuRegionalManagers">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.regional-managers.create') }}">
                            <span class="label">Add Regional Manager</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.regional-managers.index') }}">
                            <span class="label">All Regional Managers</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuMarketingManagers" style="background:transparent;">
                        <i class="bi bi-megaphone me-2"></i> <span class="label">Mkt.mgr</span>
                    </button>
                    <div class="collapse" id="menuMarketingManagers">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.marketing-managers.create') }}">
                            <span class="label">Add Marketing Manager</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.marketing-managers.index') }}">
                            <span class="label">All Marketing Managers</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuGeneralManagers" style="background:transparent;">
                        <i class="bi bi-person-badge me-2"></i> <span class="label">Gen.mgr</span>
                    </button>
                    <div class="collapse" id="menuGeneralManagers">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.general-managers.create') }}">
                            <span class="label">Add General Manager</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.general-managers.index') }}">
                            <span class="label">All General Managers</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuDivisionalManagers" style="background:transparent;">
                        <i class="bi bi-diagram-3 me-2"></i> <span class="label">D.c.mgr</span>
                    </button>
                    <div class="collapse" id="menuDivisionalManagers">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.divisional-managers.create') }}">
                            <span class="label">Add Divisional Manager</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.divisional-managers.index') }}">
                            <span class="label">All Divisional Managers</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuCountryManagers" style="background:transparent;">
                        <i class="bi bi-globe me-2"></i> <span class="label">C.mgr</span>
                    </button>
                    <div class="collapse" id="menuCountryManagers">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.country-managers.create') }}">
                            <span class="label">Add Country Manager</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.country-managers.index') }}">
                            <span class="label">All Country Managers</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuPersonalDirectory" style="background:transparent;">
                        <i class="bi bi-person-lines-fill me-2"></i> <span class="label">Personal Directory</span>
                    </button>
                    <div class="collapse" id="menuPersonalDirectory">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.personal-directory.create') }}">
                            <span class="label">Add Entry</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.personal-directory.index') }}">
                            <span class="label">All Entries</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuGeneralReminders" style="background:transparent;">
                        <i class="bi bi-bell me-2"></i> <span class="label">General Reminders</span>
                    </button>
                    <div class="collapse" id="menuGeneralReminders">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.general-reminders.create') }}">
                            <span class="label">Add Reminder</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.general-reminders.index') }}">
                            <span class="label">All Reminders</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuGeneralNotebook" style="background:transparent;">
                        <i class="bi bi-journal-text me-2"></i> <span class="label">General NoteBook</span>
                    </button>
                    <div class="collapse" id="menuGeneralNotebook">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.general-notebook.create') }}">
                            <span class="label">Add Note</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.general-notebook.index') }}">
                            <span class="label">All Notes</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuItemCategory" style="background:transparent;">
                        <i class="bi bi-tag me-2"></i> <span class="label">Item Category</span>
                    </button>
                    <div class="collapse" id="menuItemCategory">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.item-category.create') }}">
                            <span class="label">Add Category</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.item-category.index') }}">
                            <span class="label">All Categories</span>
                        </a>
                    </div>
                </div>

                <div class="mt-2">
                    <button class="btn btn-sm w-100 text-start text-white d-flex align-items-center px-2"
                        data-bs-toggle="collapse" data-bs-target="#menuTransportMaster" style="background:transparent;">
                        <i class="bi bi-truck me-2"></i> <span class="label">Transport Master</span>
                    </button>
                    <div class="collapse" id="menuTransportMaster">
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.transport-master.create') }}">
                            <span class="label">Add Transport</span>
                        </a>
                        <a class="nav-link ms-3 d-flex align-items-center" href="{{ route('admin.transport-master.index') }}">
                            <span class="label">All Transports</span>
                        </a>
                    </div>
                </div>

                </nav>
            </div>

            <div class="profile">
                <div class="dropup w-100">
                    <button class="btn w-100 d-flex align-items-center text-white" data-bs-toggle="dropdown"
                        style="background:transparent;border:none;padding:0.25rem 0;height:100%;">
                        <img src="{{ auth()->user()->profile_picture ? asset(auth()->user()->profile_picture) : 'https://i.pravatar.cc/32' }}"
                            class="rounded-circle me-2" width="28" height="28" alt="profile">
                        <span class="flex-grow-1 text-truncate label text-start small">{{ auth()->user()->full_name }}</span>
                        <i class="bi bi-chevron-up ms-auto small"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="{{ route('profile.settings') }}"><i
                                    class="bi bi-gear me-2"></i>Settings</a></li>


                        <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="px-3 py-1">
                                @csrf
                                <button class="btn btn-outline-light w-100"><i
                                        class="bi bi-box-arrow-right me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <main class="content p-3">
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>

    <!-- Global Scroll to Top Button -->
    <button id="scrollToTop" type="button" title="Scroll to top" onclick="scrollToTopNow()">
        <i class="bi bi-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Global function for smooth scroll to top
        function scrollToTopNow() {
            const contentDiv = document.querySelector('.content');
            if (contentDiv) {
                contentDiv.scrollTo({ top: 0, behavior: 'smooth' });
            }
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Global scroll to top button handler
        document.addEventListener('DOMContentLoaded', function() {
            const scrollBtn = document.getElementById('scrollToTop');
            const contentDiv = document.querySelector('.content');
            
            if (scrollBtn && contentDiv) {
                contentDiv.addEventListener('scroll', function() {
                    const y = contentDiv.scrollTop;
                    if (y > 200) {
                        scrollBtn.classList.add('show');
                        scrollBtn.classList.remove('hide');
                    } else {
                        scrollBtn.classList.add('hide');
                        scrollBtn.classList.remove('show');
                    }
                });
            }
            
            if (scrollBtn) {
                window.addEventListener('scroll', function() {
                    const y = window.scrollY || document.documentElement.scrollTop;
                    if (y > 200) {
                        scrollBtn.classList.add('show');
                        scrollBtn.classList.remove('hide');
                    } else {
                        scrollBtn.classList.add('hide');
                        scrollBtn.classList.remove('show');
                    }
                });
            }
        });

        (function () {
            const btn = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const desktopBtn = document.getElementById('desktopSidebarToggle');
            const headerBtn = document.getElementById('headerSidebarToggle');

            // --- MOBILE TOGGLE ---
            function toggleSidebar() {
                sidebar.classList.toggle('show');
                backdrop.classList.toggle('show');
            }
            if (btn && backdrop) {
                btn.addEventListener('click', toggleSidebar);
                backdrop.addEventListener('click', toggleSidebar);
            }
            if (headerBtn) {
                headerBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (window.innerWidth >= 992) {
                        // Desktop: collapse/expand sidebar
                        document.body.classList.toggle('collapsed');
                        localStorage.setItem('sidebarCollapsed', document.body.classList.contains('collapsed') ? 'true' : 'false');
                    } else {
                        // Mobile: slide sidebar
                        toggleSidebar();
                    }
                });
            }

            // --- DESKTOP COLLAPSE ---
            if (desktopBtn) {
                desktopBtn.addEventListener('click', e => {
                    e.preventDefault();
                    document.body.classList.toggle('collapsed');
                    localStorage.setItem('sidebarCollapsed', document.body.classList.contains('collapsed') ? 'true' : 'false');
                });
                if (localStorage.getItem('sidebarCollapsed') === 'true') {
                    document.body.classList.add('collapsed');
                }
            }

            // --- SET ACTIVE MENU ON PAGE LOAD ---
            (function () {
                const allCollapseElements = document.querySelectorAll('.sidebar .collapse');
                const sidebarTopMenuKey = 'sidebar:topMenuOpen';
                const currentUrlForMenu = window.location.href.split('?')[0].split('#')[0];
                const allSidebarLinks = document.querySelectorAll('.sidebar a[href]');
                let activeTopMenuId = null;
                let activeChildCollapseIds = [];

                // Find the active link and its parent collapses
                allSidebarLinks.forEach(link => {
                    if (link.href === currentUrlForMenu) {
                        let parent = link.closest('.collapse');
                        while (parent) {
                            activeChildCollapseIds.push(parent.id);
                            const isTopLevel = parent.id && parent.id.startsWith('menu') && !parent.closest('.collapse:not(#' + parent.id + ')');
                            if (isTopLevel) {
                                activeTopMenuId = parent.id;
                            }
                            parent = parent.parentElement.closest('.collapse');
                        }
                    }
                });

                const keysToRemove = [];
                for (let i = 0; i < localStorage.length; i++) {
                    const key = localStorage.key(i);
                    if (key && (key.startsWith('collapse:') || key === sidebarTopMenuKey)) {
                        keysToRemove.push(key);
                    }
                }
                keysToRemove.forEach(key => localStorage.removeItem(key));

                if (activeTopMenuId) {
                    localStorage.setItem(sidebarTopMenuKey, activeTopMenuId);
                    activeChildCollapseIds.forEach(id => {
                        localStorage.setItem('collapse:' + id, 'true');
                    });
                }
            })();

            // --- COLLAPSE HANDLING ---
            const collapseEls = document.querySelectorAll('.sidebar .collapse');
            const topMenuKey = 'sidebar:topMenuOpen';
            const savedTopMenu = localStorage.getItem(topMenuKey);

            collapseEls.forEach(collapseEl => {
                const collapse = new bootstrap.Collapse(collapseEl, { toggle: false });
                const trigger = document.querySelector('[data-bs-target="#' + collapseEl.id + '"]');

                const isTopLevel = collapseEl.id && collapseEl.id.startsWith('menu') && !collapseEl.closest('.collapse:not(#' + collapseEl.id + ')');

                // Restore saved open state
                if (isTopLevel) {
                    if (savedTopMenu && savedTopMenu === collapseEl.id) {
                        collapse.show();
                        localStorage.setItem('collapse:' + collapseEl.id, 'true');
                    } else {
                        collapse.hide();
                        localStorage.setItem('collapse:' + collapseEl.id, 'false');
                    }
                } else {
                    const isOpen = localStorage.getItem('collapse:' + collapseEl.id) === 'true';
                    if (isOpen) { collapse.show(); }
                }

                if (trigger) {
                    const isShown = collapseEl.classList.contains('show');
                    trigger.setAttribute('aria-expanded', isShown ? 'true' : 'false');
                    collapseEl.addEventListener('shown.bs.collapse', () => {
                        trigger.setAttribute('aria-expanded', 'true');
                    });
                    collapseEl.addEventListener('hidden.bs.collapse', () => {
                        trigger.setAttribute('aria-expanded', 'false');
                    });
                }
                if (trigger) {
                    trigger.addEventListener('click', e => {
                        e.preventDefault();
                        e.stopPropagation();
                        if (document.body.classList.contains('collapsed')) return false;

                        if (isTopLevel) {
                            // Close all other top-level menus
                            collapseEls.forEach(other => {
                                if (other !== collapseEl && other.id.startsWith('menu') && !other.closest('#' + collapseEl.id + '>.collapse')) {
                                    const inst = bootstrap.Collapse.getInstance(other);
                                    inst && inst.hide();
                                    localStorage.setItem('collapse:' + other.id, 'false');
                                }
                            });
                            // Remember this as the active top-level menu
                            localStorage.setItem(topMenuKey, collapseEl.id);
                        }

                        // Toggle current
                        const instance = bootstrap.Collapse.getInstance(collapseEl);
                        instance.toggle();

                        // Save state after toggle
                        setTimeout(() => {
                            const isNowOpen = collapseEl.classList.contains('show');
                            localStorage.setItem('collapse:' + collapseEl.id, isNowOpen ? 'true' : 'false');
                        }, 300);
                    });
                }
            });

            // --- WHEN SIDEBAR COLLAPSES, CLOSE ALL ---
            function closeAll() {
                collapseEls.forEach(el => {
                    const inst = bootstrap.Collapse.getInstance(el);
                    inst && inst.hide();
                    localStorage.setItem('collapse:' + el.id, 'false');
                });
                localStorage.removeItem(topMenuKey);
            }

            const observer = new MutationObserver(m => {
                m.forEach(mt => {
                    if (mt.attributeName === 'class' && document.body.classList.contains('collapsed')) {
                        closeAll();
                    }
                });
            });
            observer.observe(document.body, { attributes: true });
        })();
    </script>


    <!-- Global Delete Confirmation Modal -->
    <div class="modal fade" id="globalDeleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="globalDeleteMessage">Are you sure you want to delete this item? This action cannot be undone.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="globalDeleteConfirm" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional toast container for AJAX messages -->
    <div id="ajaxToastContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 1060;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let pending = null; // {url, row}

            function csrfToken() {
                const m = document.querySelector('meta[name="csrf-token"]');
                return m ? m.getAttribute('content') : '';
            }

            document.body.addEventListener('click', function (e) {
                const btn = e.target.closest('[data-delete-url], .ajax-delete');
                if (!btn) return;
                e.preventDefault();

                const url = btn.getAttribute('data-delete-url') || btn.getAttribute('href') || (btn.closest('form') && btn.closest('form').action);
                const row = btn.closest('tr');
                const msg = btn.getAttribute('data-delete-message') || 'Are you sure you want to delete this item? This action cannot be undone.';

                if (!url) return;
                pending = { url, row };

                document.getElementById('globalDeleteMessage').textContent = msg;
                const modal = new bootstrap.Modal(document.getElementById('globalDeleteModal'));
                modal.show();
            });

            document.getElementById('globalDeleteConfirm').addEventListener('click', async function () {
                if (!pending) return;
                const { url, row } = pending;
                const modalEl = document.getElementById('globalDeleteModal');
                const modal = bootstrap.Modal.getInstance(modalEl);

                // Use POST with method-spoofing to maximize compatibility (some servers block raw DELETE)
                try {
                    const fd = new FormData();
                    fd.append('_method', 'DELETE');
                    fd.append('_token', csrfToken());
                    let res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken(),
                            'Accept': 'application/json'
                        },
                        body: fd
                    });

                    // Treat 2xx and 3xx as success (some servers redirect after delete)
                    if (res.ok || (res.status >= 200 && res.status < 400)) {
                        if (row) row.remove();
                        modal && modal.hide();
                    } else {
                        modal && modal.hide();
                        // Try to extract a useful message only if server returned JSON
                        let txt = '';
                        try {
                            const j = await res.json();
                            if (j && j.message) txt = j.message;
                        } catch (e) {
                            // not JSON or no message; do not show blocking alert to user.
                            console.warn('Delete request failed', res.status, res.statusText);
                        }

                        // Only show an alert if server provided a clear message
                        if (txt) {
                            // Use a non-blocking UI pattern: temporarily show a toast if available, otherwise fallback to console.warn
                            try {
                                // If Bootstrap Toast container exists, create and show a toast
                                const toastContainer = document.getElementById('ajaxToastContainer');
                                if (toastContainer) {
                                    const toastEl = document.createElement('div');
                                    toastEl.className = 'toast align-items-center text-bg-danger border-0';
                                    toastEl.setAttribute('role', 'alert');
                                    toastEl.setAttribute('aria-live', 'assertive');
                                    toastEl.setAttribute('aria-atomic', 'true');
                                    toastEl.innerHTML = `<div class="d-flex"><div class="toast-body">${txt}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>`;
                                    toastContainer.appendChild(toastEl);
                                    const bToast = new bootstrap.Toast(toastEl, { delay: 4000 });
                                    bToast.show();
                                } else {
                                    console.warn('Delete failed: ' + txt);
                                }
                            } catch (e) {
                                console.warn('Delete failed', txt);
                            }
                        }
                    }
                } catch (err) {
                    modal && modal.hide();
                    console.warn('Delete network error', err);
                    // optional toast
                    try {
                        const toastContainer = document.getElementById('ajaxToastContainer');
                        if (toastContainer) {
                            const toastEl = document.createElement('div');
                            toastEl.className = 'toast align-items-center text-bg-warning border-0';
                            toastEl.setAttribute('role', 'alert');
                            toastEl.setAttribute('aria-live', 'polite');
                            toastEl.setAttribute('aria-atomic', 'true');
                            toastEl.innerHTML = `<div class="d-flex"><div class="toast-body">Delete failed — network error</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>`;
                            toastContainer.appendChild(toastEl);
                            const bToast = new bootstrap.Toast(toastEl, { delay: 4000 });
                            bToast.show();
                        }
                    } catch (e) { console.warn(e); }
                } finally {
                    pending = null;
                }
            });
        });
    </script>

    <!-- Global Select2 Initialization for All Dropdowns -->
    <script>
        $(document).ready(function () {
            // Initialize Select2 on all existing select elements
            initializeSelect2();

            // Function to initialize Select2 on select elements
            function initializeSelect2(container) {
                const selectElements = container ? $(container).find('select:not(.select2-hidden-accessible)') : $('select:not(.select2-hidden-accessible)');

                selectElements.each(function () {
                    const $select = $(this);

                    // Skip if already initialized or explicitly marked to skip
                    if ($select.hasClass('no-select2') || $select.data('select2')) {
                        return;
                    }

                    // Get custom options from data attributes
                    const placeholder = $select.data('placeholder') || $select.find('option:first').text() || 'Select an option';
                    const allowClear = $select.data('allow-clear') !== false; // Default true
                    const minimumResultsForSearch = $select.data('minimum-results-for-search') || 0; // Show search by default

                    // Initialize Select2 with Bootstrap 5 theme
                    $select.select2({
                        theme: 'bootstrap-5',
                        width: '100%',
                        placeholder: placeholder,
                        allowClear: allowClear,
                        minimumResultsForSearch: minimumResultsForSearch,
                        dropdownAutoWidth: true,
                        language: {
                            noResults: function () {
                                return "No results found";
                            },
                            searching: function () {
                                return "Searching...";
                            }
                        }
                    });
                });
            }

            // Watch for dynamically added select elements using MutationObserver
            const observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    if (mutation.addedNodes.length) {
                        mutation.addedNodes.forEach(function (node) {
                            if (node.nodeType === 1) { // Element node
                                // Check if the added node is a select or contains select elements
                                if (node.tagName === 'SELECT') {
                                    initializeSelect2($(node).parent());
                                } else if ($(node).find('select').length > 0) {
                                    initializeSelect2(node);
                                }
                            }
                        });
                    }
                });
            });

            // Start observing the document body for changes
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });

            // Re-initialize Select2 when Bootstrap modals are shown
            $(document).on('shown.bs.modal', function (e) {
                initializeSelect2(e.target);
            });
        });
    </script>

    @stack('scripts')

    <!-- Global Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="bi bi-exclamation-triangle me-2"></i>Confirm Delete
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="deleteModalMessage">Are you sure you want to delete this item?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="bi bi-trash me-1"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global Delete Modal Handler
        window.deleteModal = {
            show: function(options) {
                const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                const confirmBtn = document.getElementById('confirmDeleteBtn');
                const messageEl = document.getElementById('deleteModalMessage');
                
                // Set custom message if provided
                if (options.message) {
                    messageEl.textContent = options.message;
                } else {
                    messageEl.textContent = 'Are you sure you want to delete this item?';
                }
                
                // Remove old event listeners
                const newConfirmBtn = confirmBtn.cloneNode(true);
                confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
                
                // Add new event listener
                newConfirmBtn.addEventListener('click', function() {
                    if (options.onConfirm) {
                        options.onConfirm();
                    }
                    modal.hide();
                });
                
                modal.show();
            }
        };
    </script>
</body>

</html>