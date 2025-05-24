<div class="tab-pane fade" id="social_media">
    <div class="form-body">
{{--        <h3 class="page-title">{{ __('setting::dashboard.settings.form.tabs.social_media') }}</h3>--}}
        <div class="col-md-10">
            <div class="form-group">
                <label class="col-md-2">
                    {{ __('setting::dashboard.settings.form.facebook') }}
                </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="social[facebook]" value="{{config('setting.social.facebook','')}}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">
                    {{ __('setting::dashboard.settings.form.twitter') }}
                </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="social[twitter]" value="{{config('setting.social.twitter','')}}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">
                    {{ __('setting::dashboard.settings.form.instagram') }}
                </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="social[instagram]" value="{{config('setting.social.instagram','')}}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">
                    {{ __('setting::dashboard.settings.form.linkedin') }}
                </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="social[linkedin]" value="{{config('setting.social.linkedin','')}}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">
                    {{ __('setting::dashboard.settings.form.youtube') }}
                </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="social[youtube]" value="{{config('setting.social.youtube','')}}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">
                    {{ __('setting::dashboard.settings.form.snapchat') }}
                </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="social[snapchat]" value="{{config('setting.social.snapchat','')}}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">
                    TikTok
                </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="social[tiktok]" value="{{config('setting.social.tiktok','')}}" />
                </div>
            </div>
        </div>
    </div>
</div>
