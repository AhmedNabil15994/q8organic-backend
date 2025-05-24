@extends('apps::dashboard.layouts.app')
@section('title', __('catalog::dashboard.categories.routes.create'))
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
                        <a href="{{ url(route('dashboard.categories.index')) }}">
                            {{__('catalog::dashboard.categories.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('catalog::dashboard.categories.routes.create')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data" action="{{route('dashboard.categories.store')}}">
                    @csrf
                    <div class="col-md-12">

                        <div class="col-md-9">
                            <div class="tab-content">
                                <div class="tab-pane active fade in" id="global_setting">
                                    {{--                                    <h3 class="page-title">{{__('catalog::dashboard.categories.form.tabs.general')}}</h3>--}}
                                    <div class="col-md-10">


                                        {{--  tab for lang --}}
                                        <ul class="nav nav-tabs">
                                            @foreach (config('translatable.locales') as $code)
                                                <li class="@if($loop->first) active @endif">
                                                    <a data-toggle="tab"
                                                       href="#first_{{$code}}">{{__('catalog::dashboard.products.form.tabs.input_lang',["lang"=>$code])}}</a>
                                                </li>
                                            @endforeach
                                        </ul>

                                        {{--  tab for content --}}
                                        <div class="tab-content">

                                            @foreach (config('translatable.locales') as $code)
                                                <div id="first_{{$code}}"
                                                     class="tab-pane fade @if($loop->first) in active @endif">

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('catalog::dashboard.categories.form.title')}}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="title[{{$code}}]"
                                                                   class="form-control"
                                                                   data-name="title.{{$code}}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('catalog::dashboard.categories.form.meta_keywords')}}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                        <textarea name="seo_keywords[{{$code}}]" rows="8" cols="80"
                                                              class="form-control"
                                                              data-name="seo_keywords.{{$code}}"></textarea>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('catalog::dashboard.categories.form.meta_description')}}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                    <textarea name="seo_description[{{$code}}]" rows="8" cols="80"
                                                              class="form-control"
                                                              data-name="seo_description.{{$code}}"></textarea>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>

                                        {!! field()->file('image', __('catalog::dashboard.categories.form.image')) !!}

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::dashboard.categories.form.color')}}
                                            </label>
                                            <div class="col-md-3">
                                                <input type="color" name="color" class="form-control" data-name="color">
                                                {{--<code>{{__('catalog::dashboard.categories.form.color_hint')}}</code>--}}
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::dashboard.categories.form.sort')}}
                                            </label>
                                            <div class="col-md-3">
                                                <input type="number" name="sort" class="form-control" data-name="sort"
                                                       value="0">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        {!! field()->file('banner_image' , __('catalog::dashboard.categories.form.banner_image')) !!}

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::dashboard.categories.form.open_sub_category')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input checked type="checkbox" class="make-switch" id="open_sub_category" data-size="small"
                                                       name="open_sub_category">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::dashboard.categories.form.status')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="status" data-size="small"
                                                       name="status">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="category_id" id="root_category" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div id="jstree">
                                @include('catalog::dashboard.tree.categories.view',['mainCategories' =>
                                $mainCategories])
                            </div>
                        </div>
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

    <script type="text/javascript">
        $(function () {

            $('#jstree').jstree({
                core: {
                    multiple: false
                }
            });

            $('#jstree').on("changed.jstree", function (e, data) {
                $('#root_category').val(data.selected);
            });

        });
    </script>

@endsection
