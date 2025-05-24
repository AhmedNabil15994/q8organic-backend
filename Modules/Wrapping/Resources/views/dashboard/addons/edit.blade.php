@extends('apps::dashboard.layouts.app')
@section('title', __('wrapping::dashboard.addons.routes.update'))
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
                        <a href="{{ url(route('dashboard.wrapping_addons.index')) }}">
                            {{__('wrapping::dashboard.addons.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('wrapping::dashboard.addons.routes.update')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data" action="{{route('dashboard.wrapping_addons.update',$addons->id)}}">
                    @csrf
                    @method('PUT')
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
                                                        {{ __('wrapping::dashboard.addons.form.tabs.general') }}
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#stock" data-toggle="tab">
                                                        {{ __('wrapping::dashboard.addons.form.tabs.stock') }}
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
                                    <h3 class="page-title">{{__('wrapping::dashboard.addons.form.tabs.general')}}</h3>

                                    <ul class="nav nav-pills">
                                        @foreach (config('translatable.locales') as $k => $code)
                                            <li class="{{ $code == locale() ? 'active' : '' }}">
                                                <a id="{{$k}}-general-tab" data-toggle="tab"
                                                   aria-controls="general-tab-{{$k}}" href="#general-tab-{{$k}}"
                                                   aria-expanded="{{ $code == locale() ? 'true' : 'false' }}">{{ $code }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content px-1 pt-1">

                                        @foreach (config('translatable.locales') as $k => $code)
                                            <div role="tabpanel"
                                                 class="tab-pane {{ $code == locale() ? 'active' : '' }}"
                                                 id="general-tab-{{$k}}"
                                                 aria-expanded="{{ $code == locale() ? 'true' : 'false' }}"
                                                 aria-labelledby="{{$k}}-general-tab">

                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('wrapping::dashboard.addons.form.title')}}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="title[{{$code}}]"
                                                                   class="form-control"
                                                                   data-name="title.{{$code}}"
                                                                   value="{{ $addons->getTranslation('title',$code) }}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        @endforeach


                                        <div class="col-md-10">

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('wrapping::dashboard.addons.form.image')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a data-input="image" data-preview="holder"
                                                       class="btn btn-primary lfm">
                                                        <i class="fa fa-picture-o"></i>
                                                        {{__('apps::dashboard.general.upload_btn')}}
                                                    </a>
                                                </span>
                                                        <input name="image" class="form-control image" type="text"
                                                               readonly>
                                                        <span class="input-group-btn">
                                                    <a data-input="image" data-preview="holder"
                                                       class="btn btn-danger delete">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </a>
                                                </span>
                                                    </div>
                                                    <span class="holder" style="margin-top:15px;max-height:100px;">
                                                <img src="{{ url($addons->image) }}" alt="" style="height: 15rem;">
                                            </span>
                                                    <input type="hidden" data-name="image">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('wrapping::dashboard.addons.form.status')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" class="make-switch" id="test"
                                                           data-size="small"
                                                           name="status" {{($addons->status == 1) ? ' checked="" ' : ''}}>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="tab-pane fade in" id="stock">
                                    <h3 class="page-title">{{__('wrapping::dashboard.addons.form.tabs.stock')}}</h3>
                                    <div class="col-md-10">

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('wrapping::dashboard.addons.form.price')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="price" class="form-control"
                                                       data-name="price"
                                                       value="{{ $addons->price }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('wrapping::dashboard.addons.form.sku')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="sku" class="form-control" data-name="sku"
                                                       value="{{ $addons->sku }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('wrapping::dashboard.addons.form.qty')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" name="qty" class="form-control" data-name="qty"
                                                       value="{{ $addons->qty }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

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
                                        {{__('apps::dashboard.general.edit_btn')}}
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

    <script></script>

@endsection
