@extends('apps::dashboard.layouts.app')
@section('title', __('slider::dashboard.slider.routes.create'))
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.home.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="{{ url(route('dashboard.slider.index')) }}">
                            {{__('slider::dashboard.slider.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('slider::dashboard.slider.routes.create')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data" action="{{route('dashboard.slider.store')}}">
                    @csrf
                    <div class="col-md-12">

                        {{-- RIGHT SIDE --}}
                        <div class="col-md-3">
                            <div class="panel-group accordion scrollable" id="accordion2">
                                <div class="panel panel-default">

                                    <div id="collapse_2_1" class="panel-collapse in">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li class="active">
                                                    <a href="#general" data-toggle="tab">
                                                        {{ __('slider::dashboard.slider.form.tabs.general') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- PAGE CONTENT --}}
                        <div class="col-md-9">
                            <div class="tab-content">

                                {{-- CREATE FORM --}}
                                <div class="tab-pane active fade in" id="general">
                                    <h3 class="page-title">{{ __('slider::dashboard.slider.form.tabs.general') }}</h3>
                                    <div class="col-md-10">

{{--                                        <ul class="nav nav-pills">--}}
{{--                                            @foreach (config('translatable.locales') as $k => $code)--}}
{{--                                                <li class="{{ $code == locale() ? 'active' : '' }}">--}}
{{--                                                    <a id="{{$k}}-general-tab" data-toggle="tab"--}}
{{--                                                       aria-controls="general-tab-{{$k}}" href="#general-tab-{{$k}}"--}}
{{--                                                       aria-expanded="{{ $code == locale() ? 'true' : 'false' }}">{{ $code }}</a>--}}
{{--                                                </li>--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
{{--                                        <div class="tab-content px-1 pt-1">--}}

{{--                                            @foreach (config('translatable.locales') as $k => $code)--}}
{{--                                                <div role="tabpanel"--}}
{{--                                                     class="tab-pane {{ $code == locale() ? 'active' : '' }}"--}}
{{--                                                     id="general-tab-{{$k}}"--}}
{{--                                                     aria-expanded="{{ $code == locale() ? 'true' : 'false' }}"--}}
{{--                                                     aria-labelledby="{{$k}}-general-tab">--}}

{{--                                                    <div class="form-group">--}}
{{--                                                        <label class="col-md-2">--}}
{{--                                                            {{ __('slider::dashboard.slider.form.short_title') }}--}}
{{--                                                            - {{ $code }}--}}
{{--                                                        </label>--}}
{{--                                                        <div class="col-md-9">--}}
{{--                                                            <input type="text" class="form-control"--}}
{{--                                                                   name="short_title[{{$code}}]"--}}
{{--                                                                   value="{{ old('short_title.' . $code) }}"/>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                    <div class="form-group">--}}
{{--                                                        <label class="col-md-2">--}}
{{--                                                            {{ __('slider::dashboard.slider.form.title') }}--}}
{{--                                                            - {{ $code }}--}}
{{--                                                        </label>--}}
{{--                                                        <div class="col-md-9">--}}
{{--                                                            <input type="text" class="form-control"--}}
{{--                                                                   name="title[{{$code}}]"--}}
{{--                                                                   value="{{ old('title.' . $code) }}"/>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                    <div class="form-group">--}}
{{--                                                        <label class="col-md-2">--}}
{{--                                                            {{ __('slider::dashboard.slider.form.short_description') }}--}}
{{--                                                            - {{ $code }}--}}
{{--                                                        </label>--}}
{{--                                                        <div class="col-md-9">--}}
{{--                                                            <input type="text" class="form-control"--}}
{{--                                                                   name="short_description[{{$code}}]"--}}
{{--                                                                   value="{{ old('short_description.' . $code) }}"/>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                    <div class="form-group">--}}
{{--                                                        <label class="col-md-2">--}}
{{--                                                            {{ __('slider::dashboard.slider.form.description') }}--}}
{{--                                                            - {{ $code }}--}}
{{--                                                        </label>--}}
{{--                                                        <div class="col-md-9">--}}
{{--                                                            <input type="text" class="form-control"--}}
{{--                                                                   name="description[{{$code}}]"--}}
{{--                                                                   value="{{ old('description.' . $code) }}"/>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

{{--                                                </div>--}}
{{--                                            @endforeach--}}

{{--                                        </div>--}}

{{--                                        <hr>--}}
                                        <div class="form-group">
                                            <label
                                                class="col-md-2">{{ __('slider::dashboard.slider.form.slider_type.label') }}</label>
                                            <div class="col-md-9">
                                                <div class="mt-radio-inline">
                                                    <label class="mt-radio">
                                                        <input type="radio" name="slider_type"
                                                               id="externalLinkRadioBtn"
                                                               value="external"
                                                               onclick="toggleSliderType('external')"
                                                               checked="">
                                                        {{ __('slider::dashboard.slider.form.slider_type.external') }}
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio">
                                                        <input type="radio" name="slider_type"
                                                               id="productLinkRadioBtn"
                                                               value="product"
                                                               onclick="toggleSliderType('product')">
                                                        {{ __('slider::dashboard.slider.form.slider_type.product') }}
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio">
                                                        <input type="radio" name="slider_type"
                                                               id="categoryLinkRadioBtn"
                                                               value="category"
                                                               onclick="toggleSliderType('category')">
                                                        {{ __('slider::dashboard.slider.form.slider_type.category') }}
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="externalLinkSection" class="form-group">
                                            <label class="col-md-2">
                                                {{ __('slider::dashboard.slider.form.link') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="link" class="form-control"
                                                       data-name="link">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div id="productsSection" style="display: none;" class="form-group">
                                            <label class="col-md-2">
                                                {{ __('slider::dashboard.slider.form.products') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="product_id" class="select2 form-control"
                                                        data-name="product_id">
                                                    <option value="">
                                                        ---{{ __('slider::dashboard.slider.alert.select_products') }}
                                                        ---
                                                    </option>
                                                    @foreach($sharedActiveProducts as $k => $product)
                                                        <option value="{{ $product->id }}">
                                                            {{ $product->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div id="categoriesSection" style="display: none;" class="form-group">
                                            <label class="col-md-2">
                                                {{ __('slider::dashboard.slider.form.categories') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="category_id" class="select2 form-control"
                                                        data-name="category_id">
                                                    <option value="">
                                                        ---{{ __('slider::dashboard.slider.alert.select_categories') }}
                                                        ---
                                                    </option>
                                                    @foreach($sharedActiveCategories as $k => $category)
                                                        <option value="{{ $category->id }}">
                                                            {{ $category->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('slider::dashboard.slider.form.start_at') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group input-medium date date-picker"
                                                     data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" class="form-control" name="start_at">
                                                    <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('slider::dashboard.slider.form.end_at') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group input-medium date date-picker"
                                                     data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" class="form-control" name="end_at">
                                                    <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('slider::dashboard.slider.form.status') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test"
                                                       data-size="small"
                                                       name="status">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        {!! field()->file('image', __('slider::dashboard.slider.form.image')) !!}

                                    </div>
                                </div>
                                {{-- END CREATE FORM --}}

                            </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg blue">
                                        {{__('apps::dashboard.general.add_btn')}}
                                    </button>
                                   
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        function toggleSliderType(type = '') {
            if (type === 'external') {
                $('#externalLinkSection').show();
                $('#productsSection').hide();
                $('#categoriesSection').hide();
            } else if (type === 'product') {
                $('#externalLinkSection').hide();
                $('#categoriesSection').hide();
                $('#productsSection').show();
            } else if (type === 'category') {
                $('#externalLinkSection').hide();
                $('#productsSection').hide();
                $('#categoriesSection').show();
            }
        }
    </script>
@endsection
