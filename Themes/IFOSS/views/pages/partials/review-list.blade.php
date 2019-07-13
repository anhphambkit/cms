@php
    $reviews = $reviews ?? [];
@endphp
<div class="item">
    <div class="collapse show" id="panel-toggle-reviews">
        @foreach($reviews as $key => $review)
            <div class="comment-content">
                <div class="comment-box">
                    <div class="content-left">
                        <div class="avatar">
                            @if($review->customer)
                                <img src="{{ $review->customer->avatar }}"/>
                            @endif
                        </div>
                    </div>
                    <div class="content-right">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <div class="h6">{{ $review->customer->username }}</div>
                                <div class="rating">
                                    <div class="rating-star">
                                        @php $max = 5; @endphp
                                        @for($i = 0; $i < $review->rating; $i++)
                                            <i class="fas fa-star"></i>
                                            @php $max-- @endphp
                                        @endfor
                                        @for($i = 0; $i < $max; $i++)
                                            <i class="fas fa-star unrate"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="gray-color font-size-12">{{ $review->created_at->format('m/d/Y') }}</div>
                        </div>
                        <p class="mb-2">{{ $review->content }}</p>

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
                                        <div class="gray-color font-size-12">Jun 12, 2019</div>
                                    </div>
                                    <p class="mb-2">{{ $comment->content }}</p>
                                </div>
                            </div>
                        @endforeach
                        @if($customer = get_current_customer())
                            <div class="comment-box p-0 border-0 mt-4">
                                <div class="content-left">
                                    <div class="avatar sm">
                                        <img src="{{ $customer->avatar }}"/>
                                    </div>
                                </div>
                                <div class="content-right">
                                    <textarea name="" id="" cols="30" rows="2" data-url="{{ route('public.review.comment.create',$review->id) }}" class="form-control squared post-comment-review">Write a comment...</textarea>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>