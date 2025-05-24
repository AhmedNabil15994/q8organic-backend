@if(count($home_sections))

    @inject('appHomeDisplayType', 'Modules\Apps\Enums\AppHomeDisplayType')
    @foreach($home_sections as $home)
        @php
            $type = $home->type;
            if(in_array($type,['categories','products']) && !$home->$type()->count()){
                switch ($type){
                    case 'categories':
                    $records = Modules\Catalog\Entities\Category::active()->MainCategories()->get();
                    break;
                    case 'products':
                    $records = Modules\Catalog\Entities\Product::active()->withCount(['variants'])->orderByRaw("RAND()")->take(24)->get();
                    break;
                    default:
                    $records = null;
                    break;
                }
            }else{
                    $records = null;
            }
        @endphp
        @include('apps::frontend.home-sections.'. $type , ['records' => isset($records) && $records ? $records : $home->$type , 'home' => $home])
    @endforeach
@endif

