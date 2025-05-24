@extends('apps::dashboard.layouts.app')
@section('title', __('catalog::dashboard.products.routes.clone'))

@section('css')
    <style>
        .btn-file-upload {
            position: relative;
            overflow: hidden;
        }

        .btn-file-upload input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        .img-preview {
            height: auto;
            width: 15%;
            /*width: 77%;*/
            /*height: 200px;*/
            /*display: none;*/
        }

        .upload-input-name {
            width: 75% !important;
        }

        .btnRemoveMore {
            margin: 0 5px;
        }

        .btnAddMore {
            margin: 7px 0;
        }

        .prd-image-section {
            margin-bottom: 10px;
        }
    </style>
@endsection

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
                        <a href="{{ url(route('dashboard.products.index')) }}">
                            {{__('catalog::dashboard.products.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('catalog::dashboard.products.routes.clone')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data" action="{{route('dashboard.products.store')}}">
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
                                                    <a href="#global_setting" data-toggle="tab">
                                                        {{ __('catalog::dashboard.products.form.tabs.general') }}
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="#stock" data-toggle="tab">
                                                        {{ __('catalog::dashboard.products.form.tabs.stock') }}
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="#categories" data-toggle="tab">
                                                        {{ __('catalog::dashboard.products.form.tabs.categories') }}
                                                    </a>
                                                </li>

                                                @if(config('setting.products.toggle_variations') == 1)
                                                    <li class="">
                                                        <a href="#variations" id="click-varaition" data-toggle="tab">
                                                            {{ __('catalog::vendor.products.form.tabs.variations') }}
                                                        </a>
                                                    </li>
                                                @endif

                                                <li class="">
                                                    <a href="#images" data-toggle="tab">
                                                        {{ __('catalog::dashboard.products.form.tabs.images') }}
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="#tags" data-toggle="tab">
                                                        {{ __('catalog::dashboard.products.form.tabs.tags') }}
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#seo" data-toggle="tab">
                                                        {{ __('catalog::dashboard.products.form.tabs.seo') }}
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

                                {{-- UPDATE FORM --}}
                                <div class="tab-pane active fade in" id="global_setting">
                                    {{--                                <h3 class="page-title">{{__('catalog::dashboard.products.form.tabs.general')}}</h3>--}}

                                    <ul class="nav nav-tabs">
                                        @foreach (config('translatable.locales') as $code)
                                            <li class="@if($loop->first) active @endif">
                                                <a data-toggle="tab"
                                                   href="#global_setting{{$code}}">{{__('catalog::dashboard.products.form.tabs.input_lang',["lang"=>$code])}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">

                                        @foreach (config('translatable.locales') as $code)
                                            <div id="global_setting{{$code}}"
                                                 class="tab-pane fade @if($loop->first) in active @endif">

                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('catalog::dashboard.products.form.title')}}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="title[{{$code}}]"
                                                                   class="form-control"
                                                                   data-name="title.{{$code}}"
                                                                   {{ auth()->user()->can('edit_products_title') ? '' : 'disabled' }}
                                                                   value="{{ $product->translate($code)->title }}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('catalog::dashboard.products.form.description')}}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                    <textarea name="description[{{$code}}]" rows="8" cols="80"
                                                              class="form-control {{is_rtl($code)}}Editor"
                                                              data-name="description.{{$code}}">{{ $product->translate($code)->description }}</textarea>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('catalog::dashboard.products.form.short_description')}}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                    <textarea name="short_description[{{$code}}]" rows="8" cols="80"
                                                              class="form-control"
                                                              {{ auth()->user()->can('edit_products_description') ? '' : 'disabled' }}
                                                              data-name="short_description.{{$code}}">{{ $product->translate($code)->short_description }}</textarea>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach

                                        <div class="col-md-10">

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::dashboard.products.form.sku')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text"
                                                           name="sku"
                                                           class="form-control"
                                                           data-name="sku"
                                                           value="{{ $product->sku ?? generateRandomCode() }}">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            @if(config('setting.other.is_multi_vendors') == 1)
                                                <div class="form-group">
                                                    <label class="col-md-2">
                                                        {{__('catalog::dashboard.products.form.vendors')}}
                                                    </label>
                                                    <div class="col-md-9">
                                                        <select name="vendor_id" id="single"
                                                                class="form-control select2"
                                                                data-name="vendor_id">
                                                            <option value=""></option>
                                                            @foreach ($vendors as $vendor)
                                                                <option value="{{ $vendor['id'] }}"
                                                                    {{ ($product->vendor_id == $vendor->id) ? 'selected' : '' }}>
                                                                    {{ $vendor->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="form-group">

                                                <label class="col-md-2">
                                                    {{ __('catalog::dashboard.products.form.tabs.shipment') }}
                                                </label>

                                                <div class="col-md-3 text-left">
                                                    <label>{{__('catalog::dashboard.products.form.weight')}}</label>
                                                    <input type="number"
                                                           value="{{optional($product->shipment)['weight']}}"
                                                           placeholder="{{__('catalog::dashboard.products.form.weight')}}"
                                                           class="form-control" data-name="shipment.weight"
                                                           name="shipment[weight]">
                                                    <div class="help-block"></div>
                                                </div>

                                                <div class="col-md-2 text-left">
                                                    <label>{{__('catalog::dashboard.products.form.width')}}</label>
                                                    <input type="number"
                                                           value="{{optional($product->shipment)['width']}}"
                                                           placeholder="{{__('catalog::dashboard.products.form.width')}}"
                                                           data-name="shipment.width" class="form-control"
                                                           name="shipment[width]">
                                                    <div class="help-block"></div>
                                                </div>

                                                <div class="col-md-2 text-left">
                                                    <label>{{__('catalog::dashboard.products.form.length')}}</label>
                                                    <input type="number"
                                                           value="{{optional($product->shipment)['length']}}"
                                                           placeholder="{{__('catalog::dashboard.products.form.length')}}"
                                                           data-name="shipment.length" class="form-control"
                                                           name="shipment[length]">
                                                    <div class="help-block"></div>
                                                </div>

                                                <div class="col-md-2 text-left">
                                                    <label>{{__('catalog::dashboard.products.form.height')}}</label>
                                                    <input type="number"
                                                           value="{{optional($product->shipment)['height']}}"
                                                           placeholder="{{__('catalog::dashboard.products.form.height')}}"
                                                           class="form-control" data-name="shipment.height"
                                                           name="shipment[height]">
                                                    <div class="help-block"></div>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::dashboard.products.form.image')}}
                                                </label>
                                                <div class="col-md-9">
                                                    @if(auth()->user()->can('edit_products_image'))
                                                        @include('core::dashboard.shared.file_upload', ['image' => $product->image])
                                                    @else
                                                        <span class="holder" style="margin-top:15px;max-height:100px;">
                                                            <img src="{{ url($product->image) }}" alt=""
                                                                 style="height: 15rem;">
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::dashboard.products.form.sort')}}
                                                </label>
                                                <div class="col-md-3">
                                                    <input type="number" name="sort" class="form-control"
                                                           data-name="sort"
                                                           value="{{ $product->sort }}">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::dashboard.products.form.status')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" class="make-switch" id="test"
                                                           data-size="small"
                                                           name="status" {{($product->status == 1) ? ' checked="" ' : ''}}>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::dashboard.products.form.featured')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" class="make-switch"
                                                           data-size="small"
                                                           name="featured" {{($product->featured == 1) ? ' checked="" ' : ''}}>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="tab-pane fade in" id="categories">
                                    {{--                                <h3 class="page-title">{{__('catalog::dashboard.products.form.tabs.categories')}}</h3>--}}
                                    <div id="jstree">
                                        @include('catalog::dashboard.tree.products.edit',['mainCategories' =>
                                        $mainCategories])
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="category_id" id="root_category" value=""
                                               data-name="category_id">
                                        <div class="help-block"></div>
                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="stock">
                                    {{--                                <h3 class="page-title">{{__('catalog::dashboard.products.form.tabs.stock')}}</h3>--}}
                                    <div class="col-md-10">

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::dashboard.products.form.price')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="price" class="form-control"
                                                       data-name="price"
                                                       {{ auth()->user()->can('edit_products_price') ? '' : 'disabled' }}
                                                       value="{{ $product->price }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::dashboard.products.form.qty')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number"
                                                       name="qty"
                                                       class="form-control"
                                                       data-name="qty"
                                                       {{ auth()->user()->can('edit_products_qty') ? '' : 'disabled' }}
                                                       value="{{ $product->qty }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <hr>

                                        <h3 class="page-title">{{__('catalog::dashboard.products.form.offer')}}</h3>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::dashboard.products.form.offer_status')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="isUnchecked" id="offer-status"
                                                       name="offer_status" @if ($product->offer)
                                                       {{($product->offer->status == 1) ? ' checked="" ' : ''}}
                                                       @endif onclick="checkFunction()">
                                                <input type="hidden" class="isUnchecked" name="offer_status"
                                                       value="0"
                                                @if($product->offer)
                                                    {{($product->offer->status == 1) ? ' disabled ' : ''}}
                                                    @endif>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>


                                        <div class="offer-form" style="display:none;">
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::dashboard.products.form.offer_price')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" id="offer-form" name="offer_price"
                                                           class="form-control" data-name="offer_price"
                                                           {{ auth()->user()->can('edit_products_price') ? '' : 'disabled' }}
                                                           value="{{ $product->offer ? $product->offer->offer_price : ''}}">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::dashboard.products.form.start_at')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group input-medium date date-picker"
                                                         data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                        <input type="text" id="offer-form" class="form-control"
                                                               name="start_at" data-name="start_at"
                                                               {{ auth()->user()->can('edit_products_price') ? '' : 'disabled' }}
                                                               value="{{ $product->offer ? $product->offer->start_at : ''}}">
                                                        <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                    </div>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::dashboard.products.form.end_at')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group input-medium date date-picker"
                                                         data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                        <input type="text" id="offer-form" class="form-control"
                                                               name="end_at"
                                                               {{ auth()->user()->can('edit_products_price') ? '' : 'disabled' }}
                                                               data-name="end_at"
                                                               value="{{ $product->offer ? $product->offer->end_at  : ''}}">
                                                        <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                    </div>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                @if(config('setting.products.toggle_variations') == 1)
                                    <div class="tab-pane fade in" id="variations">
                                        {{--                                <h3 class="page-title">{{__('catalog::dashboard.products.form.tabs.variations')}}</h3>--}}

                                        <div class="row">

                                            @foreach ($options as $option)
                                                <div class="col-md-5" style="margin: 0 0 0 10px;">
                                                    <div class="form-group">
                                                        <label>{{ $option->title }}</label>
                                                        <select name="option_values"
                                                                class="option_values form-control select2"
                                                                multiple="">
                                                            <option value=""></option>
                                                            @foreach ($option->values as $value)
                                                                <option value="{{$value->id}}"
                                                                        data-name="option_values[{{ $option->id }}]">
                                                                    {{$value->title}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach

                                            {{--<div class="col-md-10">
                                                <div class="copy_variations_html">
                                                    <div class="content">
                                                        <div class="form-group">
                                                            @foreach ($options as $option)
                                                                <div class="col-md-4">
                                                                    <div class="mt-element-ribbon bg-grey-steel">
                                                                        <div
                                                                            class="ribbon ribbon-border-hor ribbon-clip ribbon-color-danger uppercase">
                                                                            <div class="ribbon-sub ribbon-clip"></div>
                                                                            {{ $option->title }}
                                                                        </div>

                                                                        <div class="ribbon-content" style="padding: 8px;">
                                                                            <div class="col-md-offset-2">
                                                                                <div class="mt-checkbox-list">
                                                                                    @foreach ($option->values as $value)
                                                                                        <label
                                                                                            class="mt-checkbox mt-checkbox-outline">
                                                                                            <input type="checkbox"
                                                                                                   name="option_values"
                                                                                                   value="{{$value->id}}"
                                                                                                   data-name="option_values[{{ $option->id }}]"/>
                                                                                            {{$value->title}}
                                                                                            <span></span>
                                                                                        </label>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="col-md-offset-4" style="margin-bottom: 14px;">
                                                            <button type="button" class="btn btn-lg green load_variations">
                                                                <i class="fa fa-refresh"></i>
                                                                {{__('catalog::dashboard.products.form.add_variations')}}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>--}}

                                        </div>
                                        <div class="row">
                                            <div class="col-md-offset-4" style="margin-bottom: 14px;">
                                                <button type="button"
                                                        class="btn btn-lg green load_variations">
                                                    <i class="fa fa-refresh"></i>
                                                    {{__('catalog::dashboard.products.form.add_variations')}}
                                                </button>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="html_option_values"></div>
                                    </div>
                                @endif

                                <div class="tab-pane fade in" id="images">
                                    {{--                                <h3 class="page-title">{{__('catalog::dashboard.products.form.tabs.images')}}</h3>--}}
                                    <div class="col-md-12">

                                        <div class="form-group">
                                            {{--<label>Upload Image</label>--}}

                                            @if(auth()->user()->can('edit_products_gallery'))
                                                <button type="button" onclick="addMoreImages()"
                                                        class="btn btn-success btnAddMore">
                                                    {{__('catalog::dashboard.products.form.btn_add_more')}} <i
                                                        class="fa fa-plus-circle"></i>
                                                </button>
                                            @endif

                                            <div id="product-images">

                                                @if(count($product->images) > 0)
                                                    @foreach($product->images as $k => $img)
                                                        <div id="prd-image-{{ $k }}" class="prd-image-section">

                                                            @if(auth()->user()->can('edit_products_gallery'))
                                                                <div class="input-group">
                                                                <span class="input-group-btn">
                                                                    <span class="btn btn-default btn-file-upload">
                                                                        {{__('catalog::dashboard.products.form.browse_image')}}
                                                                        <input type="file" name="images[{{$img->id}}]"
                                                                               onchange="readURL(this, {{ $k }});">
                                                                    </span>
                                                                </span>
                                                                    <input type="text" id="uploadInputName-{{$k}}"
                                                                           class="form-control upload-input-name"
                                                                           readonly>
                                                                    <button type="button"
                                                                            class="btn btn-danger btnRemoveMore"
                                                                            onclick="removeMoreImage('{{$k}}', '{{$img->id}}', 'db')">
                                                                        X
                                                                    </button>
                                                                </div>
                                                            @endif

                                                            <img id='img-upload-preview-{{$k}}'
                                                                 class="img-preview img-thumbnail"
                                                                 src="{{ url('uploads/products/' . $img->image) }}"
                                                                 alt="image preview"/>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div id="prd-image-0" class="prd-image-section">

                                                        @if(auth()->user()->can('edit_products_gallery'))
                                                            <div class="input-group">
                                                            <span class="input-group-btn">
                                                                <span class="btn btn-default btn-file-upload">
                                                                    {{__('catalog::dashboard.products.form.browse_image')}}
                                                                    <input type="file" name="images[]"
                                                                           onchange="readURL(this, 0);">
                                                                </span>
                                                            </span>
                                                                <input type="text" id="uploadInputName-0"
                                                                       class="form-control upload-input-name" readonly>
                                                                <button type="button"
                                                                        class="btn btn-danger btnRemoveMore"
                                                                        onclick="removeMoreImage(0, 0, 'row')">X
                                                                </button>
                                                            </div>
                                                        @endif

                                                        <img id='img-upload-preview-0'
                                                             class="img-preview img-thumbnail"
                                                             alt="image preview" style="display: none;"/>
                                                    </div>
                                                @endif

                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="tags">
                                    {{--                                <h3 class="page-title">{{__('catalog::dashboard.products.form.tabs.tags')}}</h3>--}}
                                    <div class="col-md-10">

                                        <div class="form-group">
                                            <select name="tags[]" class="form-control select2" multiple="">
                                                <option value=""></option>
                                                @foreach ($tags as $tag)
                                                    <option value="{{ $tag['id'] }}"
                                                        {{ in_array($tag->id, $product->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                        {{ $tag->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="seo">
                                    {{--                                <h3 class="page-title">{{__('catalog::dashboard.products.form.tabs.seo')}}</h3>--}}

                                    <ul class="nav nav-tabs">
                                        @foreach (config('translatable.locales') as $code)
                                            <li class="@if($loop->first) active @endif">
                                                <a data-toggle="tab"
                                                   href="#seo_{{$code}}">{{__('catalog::dashboard.products.form.tabs.input_lang',["lang"=>$code])}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">

                                        @foreach (config('translatable.locales') as $code)
                                            <div id="seo_{{$code}}"
                                                 class="tab-pane fade @if($loop->first) in active @endif">

                                                <div class="col-md-10">

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('catalog::dashboard.products.form.meta_keywords')}}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                    <textarea name="seo_keywords[{{$code}}]" rows="8" cols="80"
                                                              class="form-control"
                                                              data-name="seo_keywords.{{$code}}">{{ $product->translate($code)->seo_keywords }}</textarea>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('catalog::dashboard.products.form.meta_description')}}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                    <textarea name="seo_description[{{$code}}]" rows="8" cols="80"
                                                              class="form-control"
                                                              data-name="seo_description.{{$code}}">{{ $product->translate($code)->seo_description }}</textarea>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                                {{-- END UPDATE FORM --}}

                            </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg green">
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
        var variations = $("#click-varaition");

        // CATEGORIES TREE
        $(function () {
            $('#jstree').jstree();

            $('#jstree').on("changed.jstree", function (e, data) {
                $('#root_category').val(data.selected);
            });

            @if(!auth()->user()->can('edit_products_category'))
            $('#jstree li').each(function () {
                $("#jstree").jstree().disable_node(this.id);
            });
            @endif

        });

        // PRODUCT HAS RELATION WITH OFFER / NEW ARRIVAL
        $(function () {

            @if ($product->offer)
            $("input#offer-form").prop("disabled", false);
            $('.offer-form').css('display', '');
            variations.hide()
            $(".variation-add input , .variation-edit input").prop("disabled", true);
            @endif

            @if ($product->newArrival)
            $("input#arrival-form").prop("disabled", false);
            $('.arrival-form').css('display', '');
            @endif

        });

        // DISABLED OR UNDISABLED OF STATUS FORM
        $("#new-arraival-status").click(function (e) {

            if ($('#new-arraival-status').is(':checked')) {
                $("input#arrival-form").prop("disabled", false);
                $('.arrival-form').css('display', '');

            } else {
                $("input#arrival-form").prop("disabled", true);
                $('.arrival-form').css('display', 'none');

            }

        });

        // CHANGE STATUS OF CHECKBOX WITH 0 VALUE OR 1
        function checkFunction() {
            $('[name="offer_status"]').change(function () {
                if ($(this).is(':checked'))
                    $(this).next().prop('disabled', true);
                else
                    $(this).next().prop('disabled', false);
            });

            $('[name="arrival_status"]').change(function () {
                if ($(this).is(':checked'))
                    $(this).next().prop('disabled', true);
                else
                    $(this).next().prop('disabled', false);
            });

        }

        // GALLERY FORM / ADD NEW UPLOAD BUTTON
        $(document).ready(function () {
            var html = $("div.getGalleryForm").html();
            $(".addGallery").click(function (e) {
                e.preventDefault();
                $(".galleryForm").append(html);
                $('.lfm').filemanager('image');
            });
        });

        // DELETE UPLOAD BUTTON & IMAGE
        $(".galleryForm").on("click", ".delete-gallery", function (e) {
            e.preventDefault();
            $(this).closest('.form-group').remove();
        });


        // CHANGE DISPLAY OF OFFER FORM
        $("#offer-status").click(function (e) {

            if ($('#offer-status').is(':checked')) {
                $("input#offer-form").prop("disabled", false);
                $('.offer-form').css('display', '');
                variations.hide()
                $(".variation-add input").prop("disabled", true);
            } else {
                $("input#offer-form").prop("disabled", true);
                $('.offer-form').css('display', 'none');
                variations.show()
                $(".variation-add input").prop("disabled", false);
            }

        });
        // variation
        $(document).ready(function () {
            $(".load_variations").click(function (e) {
                e.preventDefault();

                var option_values = [];

                /*$.each($("input[name='option_values']:checked"), function () {
                    option_values.push($(this).val());
                });*/

                $(".option_values  > option:selected").each(function () {
                    option_values.push($(this).val());
                });

                $.ajax({
                    type: 'GET',
                    url: '{{ url(route('dashboard.values_by_option_id')) }}',
                    data: {
                        values_ids: option_values
                    },
                    dataType: 'html',
                    encode: true,
                    beforeSend: function (xhr) {
                        $('.load_variations').prop('disabled', true);
                    }
                })
                    .done(function (res) {
                        $('.html_option_values').html(res);
                        ComponentsDateTimePickers.init()
                        $('.load_variations').prop('disabled', false);
                    })
                    .fail(function (res) {
                        // console.log(res);
                        alert("{{__('catalog::dashboard.products.validation.select_option_values')}}");
                        $('.load_variations').prop('disabled', false);
                    });
            });
        });

        //======

        $("body").on("click", ".offer-status", function () {
            var elm = $(this)
            var form = $(`.offer-form_${elm.data('index')}`)
            if (elm.is(':checked')) {
                form.find("input#offer-form_v").prop("disabled", false);
                form.show()
            } else {
                form.find("input#offer-form_v").prop("disabled", true);
                form.hide()
            }

        })

    </script>

    <script>
        function readURL(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var label = input.files[0].name;

                reader.onload = function (e) {
                    var imgUpload = $('#img-upload-preview-' + id);
                    imgUpload.show();
                    imgUpload.attr('src', e.target.result);
                    $('#uploadInputName-' + id).val(label);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        var rowCountsArray = [];
        @foreach($product->images as $k => $img)
        rowCountsArray.push({{ $k }});

        @endforeach

        function addMoreImages() {

            var rowCount = Math.floor(Math.random() * 9000000000) + 1000000000;
            rowCountsArray.push(rowCount);

            var productImages = $('#product-images');
            var row = `
            <div id="prd-image-${rowCount}" class="prd-image-section">
                <div class="input-group">
                    <span class="input-group-btn">
                         <span class="btn btn-default btn-file-upload">
                         {{__('catalog::dashboard.products.form.browse_image')}}<input type="file" name="images[${rowCount}]" onchange="readURL(this, ${rowCount});">
                         </span>
                    </span>
                    <input type="text" id="uploadInputName-${rowCount}" class="form-control upload-input-name" readonly>
                    <button type="button" class="btn btn-danger btnRemoveMore" onclick="removeMoreImage(${rowCount}, ${rowCount}, 'row')">X</button>
                </div>
                <img id='img-upload-preview-${rowCount}' class="img-preview img-thumbnail" alt="image preview" style="display: none;"/>
            </div>`;

            productImages.prepend(row);
        }

        function removeMoreImage(index, rowId, flag = '') {

            if (rowCountsArray.length > 1) {

                if (flag === 'db') {

                    var r = confirm("{{ __('catalog::dashboard.products.form.add_ons.confirm_msg') }}");
                    if (r == true) {

                        $.ajax({
                            url: "{{route('dashboard.products.delete_product_image')}}?id=" + rowId,
                            type: 'get',
                            dataType: 'JSON',
                            contentType: false,
                            cache: false,
                            processData: false,

                            beforeSend: function () {
                                $('.progress-info').show();
                                $('.progress-bar').width('0%');
                                resetErrors();
                            },
                            success: function (data) {

                                if (data[0] == true) {

                                    $('#prd-image-' + index).remove();
                                    const k = rowCountsArray.indexOf(parseInt(index));
                                    if (k > -1) {
                                        rowCountsArray.splice(k, 1);
                                    }

                                    successfully(data);
                                    resetErrors();
                                } else {
                                    displayMissing(data);
                                }

                            },
                            error: function (data) {
                                displayErrors(data);
                            },
                        });

                    }
                } else {
                    $('#prd-image-' + index).remove();
                    const i = rowCountsArray.indexOf(index);
                    if (i > -1) {
                        rowCountsArray.splice(i, 1);
                    }
                }

            } else {
                alert("{{__('catalog::dashboard.products.form.add_ons.at_least_one_field')}}");
                return false;
            }

        }
    </script>

@endsection
