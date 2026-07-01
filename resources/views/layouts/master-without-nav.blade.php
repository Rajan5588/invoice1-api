<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-topbar="light" data-sidebar-image="none"
    data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | ACT T CONNECT - Invoice & Billing Software</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ACT T CONNECT - Smart Invoice & Billing Software for businesses. Generate invoices, track payments, manage customers, and simplify accounting." />
    <meta name="keywords" content="Invoice Software, Billing Software, Accounting App, Payment Tracking, Customer Management, Online Invoices, Business Finance" />
    <meta name="author" content="ACT T CONNECT" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/logonewsrgi.png') }}" width="34px;">

    @include('layouts.head-css')
</head>



@yield('body')

@yield('content')

@include('layouts.vendor-scripts')
</body>

</html>
