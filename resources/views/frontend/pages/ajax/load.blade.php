<div id="load" style="position: relative;">
    @foreach($reviews as $review)
        <div class="fp__single_comment {{$loop->first ?  'm-0 border-0' : ''}}">

            <img src="{{asset($review->user->avatar)}}" alt="review"
                 class="img-fluid">
            <div class="fp__single_comm_text">
                <h3>{{$review->user->name}}
                    <span>{{ date('d m Y', strtotime($review->created_at)) }} </span>
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
            </div>
        </div>

    @endforeach
</div>
<div class="mt-4">
    {{ $reviews->links() }}

</div>

