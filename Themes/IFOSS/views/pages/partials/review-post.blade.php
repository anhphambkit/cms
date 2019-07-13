<hr>
<div class="product-information" >
    <div class="text-paraph title dark">Write a review</div>
    <div class="p-4" style="background-color: rgba(150,196,189,.2); border: 1px solid rgba(150,196,189,.8);">
        {!! Form::open(['id' => 'form-post-review', 'route' => ['public.review.create', $productInfo['product']->id]]) !!}
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Your review <span class="text-red">*</span></label>
            <div class="col-sm-9">
                <textarea name="content" id="content-review" cols="30" rows="4" class="form-control squared"></textarea>
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label class="col-sm-3 col-form-label align-items-center d-flex">Your Rating</label>
            <div class="col-sm-9">
                <div class="form-rating-control">
                    <?php for ($i=5; $i > 0; $i--) { 
                        if ($i <= 5 && $i > 3) {
                            $text = 'Excellent!';
                        }
                        else if($i <= 3 && $i > 1){
                            $text = 'Good!';
                        }
                        else{
                            $text = 'Bad!';
                        }
                    ?>
                    <span>
                        <input type="radio" name="rating" id="<?php echo $i; ?>-star" value="<?php echo $i; ?>" data-toggle="tooltip" data-original-title="<?php echo $text; ?>">
                        <label for="<?php echo $i; ?>-star"><i class="fas fa-star"></i></label>
                    </span>
                    <?php } ?>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <div class="form-group row">
            <div class="col-sm-9 offset-sm-3">
                @if(get_current_customer())
                    <button type="button" class="btn btn-custom justify-content-center btn-write-review">Submit</button>
                @else
                   <a href="{{ route('public.customer.login') }}" class="btn btn-custom justify-content-center">Login to write a review</a> 
                @endif
            </div>
        </div>
    </div>
</div>