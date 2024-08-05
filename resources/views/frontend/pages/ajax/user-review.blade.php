<div id="load" style="position: relative;">
    @foreach($reviews as $review)
        <div class="fp__single_comment">
            <img src="{{asset($review->product->thumb_image)}}" alt=" review" class="img-fluid">
            <div class="fp__single_comm_text">

                <h3><a href="{{route('product.show',$review->product->slug)}}">{{$review->product->name}}</a> <span>{{ date('d m Y', strtotime($review->created_at)) }}</span>
                </h3>
                <span class="rating">

                    @for($i=1; $i<=5; $i++)

                        @if($i <= $review->rating)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="fal fa-star"></i>
                        @endif

                    @endfor

                </span>
                <p>{{$review->review}}</p>
                @if(!$review->status)
                <span class="status inactive"
                      data-bs-toggle="tooltip"
                      data-bs-placement="top"
                      data-bs-custom-class="custom-tooltip"
                      data-bs-title="Your Review is waiting to be approved by Admin">Inactive</span>
                @else
                    <span class="status active" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Your Review is approved">Active</span>
                @endif
            </div>
        </div>

    @endforeach
</div>
<div class="mt-4">
    {{ $reviews->links() }}

</div>

@push('scripts')
    <script>

    </script>
@endpush
