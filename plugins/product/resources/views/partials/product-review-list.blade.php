@php
    $reviews = $reviews ?? [];
    $startOnImage = asset('backend/core/base/packages/review-star-on.png');
    $startOffImage = asset('backend/core/base/packages/review-star-off.png');
@endphp
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Reviews and rating</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                <li><a data-action="close"><i class="ft-x"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="media-list list-group">
                @foreach($reviews as $key => $review)
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action media">
                        <div class="media-left">
                            <img class="media-object rounded-circle" src="{{ $review->customer->avatar }}" alt="Generic placeholder image" style="width: 48px;height: 48px;">
                        </div>
                        <div class="media-body">
                            <h5 class="list-group-item-heading">
                                {{ $review->customer->username }} &nbsp;
                                <span class="ratings" title="gorgeous">
                                    @php $max = 5; @endphp
                                    @for($i = 0; $i < $review->rating; $i++)
                                        <img src="{{ $startOnImage }}" title="gorgeous">&nbsp;
                                        @php $max-- @endphp
                                    @endfor
                                    @for($i = 0; $i < $max; $i++)
                                        <img src="{{ $startOffImage }}" title="gorgeous">&nbsp;
                                    @endfor
                                </span>
                                <small class="float-right">{{ $review->created_at->format('m/d/Y') }}</small>
                            </h5>
                            <span class="list-group-item-text">{{ $review->content }}</span>
                            @foreach($review->comments as $index => $comment)
                                <div class="comment-box p-0 border-0 mt-4">
                                    <div class="content-left">
                                        <div class="avatar sm">
                                            <img src="{{ $comment->author->avatar }}"/>
                                        </div>
                                    </div>
                                    <div class="content-right">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div class="h6 mb-0">{{ $comment->author->username }}</div>
                                            <div class="gray-color font-size-12">{{ $comment->created_at->format('m/d/Y') }}</div>
                                        </div>
                                        <p class="mb-2">{{ $comment->content }}</p>
                                    </div>
                                </div>
                            @endforeach
                            <div class="comment-box p-0 border-0 mt-4">
                                <textarea name="content" cols="30" rows="2" data-url="{{ route('admin.review.comment.create',$review->id) }}" class="form-control squared post-comment-review">Write a comment...</textarea>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>