<div class="tab-pane fade" id="v-pills-reviews" role="tabpanel"
     aria-labelledby="v-pills-reviews-tab">
    <div class="fp_dashboard_body dashboard_review">
        <h3>Your reviews</h3>
        <div class="fp__review_area">
            <div class="fp__comment pt-0 mt_20">


                @if ($reviews->hasPages())
                    <div class="fp__pagination ">
                        <div class="row">
                            <div class="col-12" id="reviews-pagination">

                                <section class="reviews">
                                    @include('frontend.pages.ajax.user-review')
                                </section>


                                {{--                                                                    {{ $reviews->links() }}--}}
                            </div>
                        </div>
                    </div>
                @else
                    @foreach($reviews as $review)
                        <div class="fp__single_comment {{$loop->first ?  'm-0 border-0' : ''}}">

                            <img src="{{asset($review->product->thumb_image)}}" alt=" review" class="img-fluid">
                            <div class="fp__single_comm_text">

                                <h3>
                                    <a href="{{route('product.show',$review->product->slug)}}">{{$review->product->name}}</a>
                                    <span>{{ date('d m Y', strtotime($review->created_at)) }}</span>
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
                                          data-bs-title="Your Review is waiting to be approved by Admin"
                                    >Inactive</span>
                                @else
                                    <span class="status active" data-bs-toggle="tooltip" data-bs-placement="top"
                                          data-bs-title="Your Review is approved">Active</span>
                                @endif
                            </div>
                        </div>

                    @endforeach

                @endif
                @if(count($reviews) === 0)
                    <div class="alert alert-warning mt-4">No reviews found!</div>

                @endif

            </div>
        </div>
    </div>
</div>


@push('scripts')

    <script>

        $(document).ready(function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        })

        $(document).on('click', '#reviews-pagination .pagination a', function (e) {
            e.preventDefault();

            var url = $(this).attr('href');
            fetchReviews(url);
            window.history.pushState("", "", url);

        });


        function fetchReviews(url) {
            $.ajax({
                url: url
            }).done(function (data) {
                $('.reviews').html(data);
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }).fail(function () {
                alert('Reviews could not be loaded.');
            });
        }


    </script>
@endpush
