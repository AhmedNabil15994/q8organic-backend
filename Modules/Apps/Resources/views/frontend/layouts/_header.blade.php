

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '--') || {{ config('app.name') }} </title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="keywords" content="@yield('meta_keywords', '')">
    <meta name="author" content="{{ config('setting.app_name.'.locale()) ?? '' }}">

    @foreach(config("setting.social.markting", [] ) as $val)
       {!! isset($val) ? $val : '' !!}
    @endforeach

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="{{asset('frontend/css/font-awesome.css')}}">
    <link href="{{ url('admin/assets/global/plugins/grapick/grapick.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('frontend/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/select2.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/smoothproducts.css')}}" type="text/css">
    <link href="{{asset('SewidanField/plugins/ck-editor-5/css/ckeditor.css')}}" rel="stylesheet" id="style_components" type="text/css" />
    <link rel="stylesheet" href="{{asset('frontend/css/vars.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/style-'.locale().'.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <link href="{{asset('frontend/plugins/live-search/jquery.autocomplete.css')}}" rel="stylesheet" id="style_components" type="text/css" />

    @stack('plugins_styles')

    {{-- Start - Bind Css Code From Dashboard Daynamic --}}
    {!! config('setting.custom_codes.css_in_head') ?? null !!}
    {{-- End - Bind Css Code From Dashboard Daynamic --}}

    @if(isset(Setting::get('theme_sections')['css']))
    <style>
    {!! Setting::get('theme_sections')['css'] !!}
    </style>
    @endif

    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">

    <style>
        #wmobile{
            position: fixed;
            bottom: 55px;
            right: -12;
            height:60px;

        }

        #wdesktop{
            position: fixed;
            bottom: 10px;
            right: 15px;
            z-index: 99999;
        }

        #wmobile img,#wdesktop img{
            height:60px;
        }
    </style>
    @stack('styles')

    {{-- Start - Bind Js Code From Dashboard Daynamic --}}
    {!! config('setting.custom_codes.js_before_head') ?? null !!}
    {{-- End - Bind Js Code From Dashboard Daynamic --}}


    <link rel="icon" href="{{ config('setting.favicon') ? url(config('setting.favicon')) : url('frontend/favicon.png') }}"/>
    <meta property="og:image" content="{{ config('setting.favicon') ? url(config('setting.favicon')) : url('frontend/favicon.png') }}"/>
</head>
