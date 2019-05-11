<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-11
 * Time: 14:36
 */
?>
@extends("layouts.master")
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Library</li>
            </ol>
        </nav>
        <div class="filter-categories">
            <div class="filter-categories-title">Select your desired space</div>
            <div class="content">
                <div class="row justify-content-center">
                    <div class="content-title col-md-9">{{ $businessTypeName }}</div>
                    <div class="clearfix w-100"></div>
                    @if($spaces->count() > 1)
                        @php
                            $numberSplit = ($spaces->count()%3 === 1) ? 2 : 3;
                            $firstChunk = collect();
                            $spaceChunks = $spaces;
                            if ($numberSplit == 2) {
                                $firstChunk = $spaces;
                                $spaceChunks = $firstChunk->splice(2);
                            }

                            $spaceChunks = $spaceChunks->split(3);
                            if ($firstChunk->isNotEmpty())
                                $spaceChunks->prepend($firstChunk);
                        @endphp
                        @foreach($spaceChunks as $spaceChunk)
                            <div class="col-lg-3 col-md-6">
                                <ul class="content-item">
                                    @foreach($spaceChunk as $space)
                                        <li>
                                            <a href="{{ ($space->id > 0) ? route('public.design-ideal.business-type.space', [ 'businessType' => $businessType, 'space' => $space->slug ]) : route('public.design-ideal.business-type.space.all-rooms', [ 'businessType' => $businessType ]) }}">{{ $space->text }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="text-right">
                    <button class="btn btn-outline-custom">
                        <a href="{{ route('public.design-ideal') }}" class="btn-link-custom">
                            Back
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <section class="design-ideas">
        <div class="container-fluid">
            <div class="text-center">
                <div class="section-title-s2">New design ideas</div>
            </div>
            @include("pages.partials.list-look-book")
            <div class="text-center py-4">
                <a href="javascript:void(0);" class="btn-view-icon"><i class="fas fa-plus"></i> <span>Load more</span></a>
            </div>
        </div>
    </section>
@stop
