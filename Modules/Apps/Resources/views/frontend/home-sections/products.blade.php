@if(count($records) > 0)

    <div class="container {{isset($home->classes['container']) ? $home->classes['container'] : ''}}">

        @if ($home->display_type == $appHomeDisplayType::__default)
            <div class="home-products">
                <h3 class="slider-title {{isset($home->classes['title']) ? $home->classes['title'] : ''}}">   {{$home->title}}</h3>
                <div class="owl-carousel products-slider">
                    @foreach($records as $k => $record)
                        @include('catalog::frontend.products.components.single-product',['product'=> $record,'home' => $home])
                    @endforeach
                </div>
            </div>
        @else
            <h3 class="slider-title">{{ $home->title }}</h3>
            @php
                $numOfColumns = $home->grid_columns_count ?? 4;
                $bootstrapColWidth = 12 / $numOfColumns;
            @endphp
            <div class="list-products">
                <div class="row">
                    @foreach ($records as $k => $record)
                        <div class="col-md-{{ $bootstrapColWidth ?? '3' }} col-6">
                            @include('catalog::frontend.products.components.single-product',['product'=> $record,'home' => $home])
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endif
