@extends("layouts.master")
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.design-ideal') }}">Design Ideas</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.design-ideal.business-type', [ 'businessType' => $businessType ]) }}">{{ $businessTypeName }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $spaceName }}</li>
            </ol>
        </nav>
    </div>
    <section class="product-categories">
        <div class="product-categories--tabs">
            <div class="container">
                <ul class="nav nav-outline mb-4">
                    @foreach ($spaces as $space)
                        <li class="nav-item">
                            <a class="nav-link {{ (strtolower($space->text) == strtolower($spaceName)) ? 'active' : '' }}"
                               href="{{ ($space->id > 0) ? route('public.design-ideal.business-type.space', [ 'businessType' => $businessType, 'space' => $space->slug ]) : route('public.design-ideal.business-type.space.all-rooms', [ 'businessType' => $businessType ]) }}">
                                {{ $space->text }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="design-ideas">
                <div class="container-fluid">
                    @include("pages.partials.list-look-book", [
                        'currentBusinessSlug' => $businessType,
                        'currentBusinessName' => $businessTypeName
                    ])
                </div>
            </div>
        </div>
    </section>
@stop

@section('variable-scripts')
    <script>
        const PRODUCT = {
            GET_OVERVIEW_INFO_POPUP : "{{ route('ajax.product.get_overview_info_product_popup') }}",
            DETAIL_PRODUCT : "{{ route('public.product.detail', [ 'url' => '' ]) }}",
        };
    </script>
@stop