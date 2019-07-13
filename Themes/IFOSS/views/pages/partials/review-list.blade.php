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
                        
                        <div class="comment-box p-0 border-0 mt-4">
                            <div class="content-left">
                                <div class="avatar sm">
                                    <img src="https://scontent.fsgn5-7.fna.fbcdn.net/v/t1.0-9/37369674_2068190029912599_3344800464314040320_n.jpg?_nc_cat=103&_nc_oc=AQl2cl5eHz9yIE3_fcKCMChVr8sigPhf4rPlrm-J2SwJZqs1a3sYHwR2AjGZT4T972RIcP7ERjX4OB5lLgNJA3X-&_nc_ht=scontent.fsgn5-7.fna&oh=eb469c57638194c5dbc440063e2ea84b&oe=5DAE04B4"/>
                                </div>
                            </div>
                            <div class="content-right">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="h6 mb-0">Tuan Trinh</div>
                                    <div class="gray-color font-size-12">Jun 12, 2019</div>
                                </div>
                                <p class="mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>

                        @if($customer = get_current_customer())
                            <div class="comment-box p-0 border-0 mt-4">
                                <div class="content-left">
                                    <div class="avatar sm">
                                        <img src="{{ $customer->avatar }}"/>
                                    </div>
                                </div>
                                <div class="content-right">
                                    <textarea name="" id="" cols="30" rows="2" class="form-control squared">Write a comment...</textarea>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>