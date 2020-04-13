<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="description" content="CourseWare - HTML5 Template By Jewel Theme">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- favicon -->
        <link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="32x32">
        <link rel="icon" href="{{ asset('images/favicon-300x300.png') }}" sizes="192x192">
        <link rel="apple-touch-icon-precomposed" href="{{ asset('images/favicon-300x300.png') }}"> 

        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- Import Template Icons CSS Files -->
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/simple-line-icons.css') }}">

        <!-- Import Bootstrap CSS File --> 
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"> 

        <!-- Import Owl Carousel CSS File -->

        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">

        <!-- TimeTo Countdown CSS Files --> 
        <link rel="stylesheet" href="{{ asset('assets/css/timeTo.css') }}">
        
        <!-- Import Template's CSS Files --> 
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

        <style type="text/css">
            .top-contact span {
                color: #fff ;
            }
            .header-top a{
                color: #fff ;
            }
        </style>
    </head>

    <body>
        <div id="app">

            <main-App />
            

            <!--<script type="application/javascript" src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
            <script type="application/javascript" src="{{ asset('assets/js/plugins.js') }}"></script>
            <script type="application/javascript" src="{{ asset('assets/js/main.js') }}"></script>

            <script type="application/javascript"> 
                $(document).ready(function() {
                    "use strict"; 
                    // home contact info
                    $(".trggericon").on("click", function(e){ 
                      $(this).parent('.top-contact').addClass('togglecontact');
                    });
                    $(".top-contact .close").on("click", function(e){ 
                      $(this).parent('.top-contact').removeClass('togglecontact');
                    });
                });
            </script>-->
        </div>
    </body>
</html>
