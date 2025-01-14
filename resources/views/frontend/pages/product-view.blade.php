@extends('frontend.layouts.master')

@section('content')
    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset(config('settings.breadcrumb')) }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>Product Details</h1>
                    <ul>
                        <li><a href="{{url('/')}}">home</a></li>
                        <li><a href="javascript:;">menu Details</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--=============================
        MENU DETAILS START
    ==============================-->
    <section class="fp__menu_details mt_115 xs_mt_85 mb_95 xs_mb_65">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-9 wow fadeInUp" data-wow-duration="1s">
                    <div class="exzoom hidden" id="exzoom">

                        <div class="exzoom_img_box fp__menu_details_images">
                            <ul class='exzoom_img_ul'>
                                <li><img class=" img-fluid w-100" src="{{asset($product->thumb_image)}}" alt="product">
                                </li>

                                @foreach($product->gallery as $image)
                                    @if (!$loop->first)
                                        <li><img class="zoom img-fluid w-100" src="{{ asset($image->image) }}"
                                                 alt="product"></li>
                                    @endif
                                @endforeach

                            </ul>
                        </div>
                        <div class="exzoom_nav"></div>
                        <p class="exzoom_btn">
                            <a href="javascript:void(0);" class="exzoom_prev_btn"> <i class="far fa-chevron-left"></i>
                            </a>
                            <a href="javascript:void(0);" class="exzoom_next_btn"> <i class="far fa-chevron-right"></i>
                            </a>
                        </p>
                    </div>
                </div>


                <div class="col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_details_text">
                        <h2>{{$product->name}}</h2>
                        <p class="rating">
                            @for($i=1; $i<=5; $i++)

                                @if($i <= $product->reviews_avg_rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="fal fa-star"></i>
                                @endif

                            @endfor
                            <span>{{$product->reviews_count}} </span>
                        </p>
                        <h3 class="price">
                            @if ($product->offer_price > 0)
                                {{currencyPosition($product->offer_price)}}
                                <del>{{currencyPosition($product->price)}}</del>
                            @else
                                {{currencyPosition($product->price)}}
                            @endif
                        </h3>
                        <p class="short_description">{{$product->short_description}}</p>


                        <form action="" id="v_add_to_cart_form">
                            @csrf
                            <input type="hidden" name="base_price" class="v_base_price"
                                   value="{{ $product->offer_price > 0 ? $product->offer_price : $product->price }}">

                            <input type="hidden" name="product_id" value="{{$product->id}}">


                            {{--SIZE OPTIONS--}}
                            @if($product->productSizes()->exists())
                                <div class="details_size">
                                    <h5>select size</h5>

                                    @foreach($product->productSizes as $productSize)
                                        <div class="form-check">
                                            <input class="form-check-input v_product_size" type="radio"
                                                   name="product_size" id="size-{{$productSize->id}}"
                                                   data-price="{{$productSize->price}}" value="{{$productSize->id}}">
                                            <label class="form-check-label" for="size-{{$productSize->id}}">
                                                {{$productSize->name}}
                                                <span>+ {{currencyPosition($productSize->price)}}</span>
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            @endif


                            {{-- OPTIONS--}}
                            @if ($product->productOptions()->exists())
                                <div class="details_extra_item">
                                    <h5>select option <span>(optional)</span></h5>

                                    @foreach($product->productOptions as $productOption)

                                        <div class="form-check">
                                            <input class="form-check-input v_product_option" type="checkbox"
                                                   name="product_option[]" value="{{$productOption->id}}"
                                                   id="option-{{$productOption->name}}"
                                                   data-price="{{$productOption->price}}">
                                            <label class="form-check-label" for="option-{{$productOption->id}}">
                                                {{$productOption->name}}
                                                <span>+ {{currencyPosition($productOption->price)}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- QUANTITY--}}
                            <div class="details_quentity">
                                <h5>select quentity</h5>
                                <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                                    <div class="quentity_btn">
                                        <button class="btn btn-danger v_decrement"><i class="fal fa-minus"></i></button>
                                        <input type="text" placeholder="1" id="v_quantity" value="1" name="quantity">
                                        <button class="btn btn-success v_increment"><i class="fal fa-plus"></i></button>
                                    </div>
                                    <h3 id="v_total_price">{{currencyPosition($product->offer_price > 0 ? $product->offer_price : $product->price) }}</h3>
                                </div>
                            </div>
                        </form>


                        <ul class="details_button_area d-flex flex-wrap">

                            @if($product->quantity === 0)
                                <li><a class="common_btn bg-danger" href="javascript:;">Stock Out</a></li>
                            @else
                                <li><a class="common_btn v_submit_button" href="javascript:;">add to cart</a></li>
                            @endif


                            <li><a class="wishlist" href="#"><i class="far fa-heart"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_description_area mt_100 xs_mt_70">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                        aria-selected="true">Description
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact" type="button" role="tab"
                                        aria-controls="pills-contact" aria-selected="false">Reviews
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                 aria-labelledby="pills-home-tab" tabindex="0">
                                <div class="menu_det_description">
                                    {!!  $product->long_description!!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                 aria-labelledby="pills-contact-tab" tabindex="0">
                                <div class="fp__review_area">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h4>{{count($reviews)}} reviews</h4>
                                            <div class="fp__comment pt-0 mt_20">


                                                {{--@foreach($reviews as $review)
                                                    <div class="fp__single_comment m-0 border-0">

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

                                                @endforeach--}}
                                                    @if ($reviews->hasPages())
                                                        <div class="fp__pagination ">
                                                            <div class="row">
                                                                <div class="col-12" id="reviews-pagination">

                                                                    <section class="articles">
                                                                        @include('frontend.pages.ajax.load')
                                                                    </section>


{{--                                                                    {{ $reviews->links() }}--}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                @else
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


                                                    @endif
                                                @if(count($reviews) === 0)
                                                    <div class="alert alert-warning mt-4">No review found!</div>

                                                @endif

                                            </div>

                                        </div>
                                        @auth
                                            <div class="col-lg-4">
                                                <div class="fp__post_review">
                                                    <h4>write a Review</h4>
                                                    <form action="{{ route('product-review.store') }}" method="POST">
                                                        @csrf
                                                        {{--      <p class="rating">
                                                                  <span>select your rating : </span>
                                                                  <i class="fas fa-star"></i>
                                                                  <i class="fas fa-star"></i>
                                                                  <i class="fas fa-star"></i>
                                                                  <i class="fas fa-star"></i>
                                                                  <i class="fas fa-star"></i>
                                                              </p>--}}
                                                        <div class="row">
                                                            <div class="col-xl-12 mt-3">
                                                                <label>Choose a rating</label>
                                                                <select name="rating" id="rating_input"
                                                                        class="form-control">
                                                                    <option value="5">5</option>
                                                                    <option value="4">4</option>
                                                                    <option value="3">3</option>
                                                                    <option value="2">2</option>
                                                                    <option value="1">1</option>
                                                                </select>
                                                                <input type="hidden" name="product_id"
                                                                       value="{{$product->id}}">
                                                            </div>

                                                            <div class="col-xl-12 mt-4">
                                                                <label for="">Review</label>
                                                                <textarea style="margin-top: 2px" rows="3" name="review"
                                                                          placeholder="Write your review"></textarea>
                                                            </div>
                                                            <div class="col-12">
                                                                <button class="common_btn" type="submit">submit
                                                                    review
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-lg-4">
                                                <h4>write a Review</h4>
                                                <div class="alert alert-warning mt-4 shadow-sm">Please login first to
                                                    add review.
                                                </div>
                                            </div>

                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(count($relatedProducts) > 0)
                <div class="fp__related_menu mt_90 xs_mt_60">
                    <h2>related item</h2>
                    <div class="row related_product_slider">

                        @foreach($relatedProducts as $relatedProduct)
                            <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                                <div class="fp__menu_item">
                                    <div class="fp__menu_item_img">
                                        <img src="{{asset($relatedProduct->thumb_image)}}"
                                             alt="{{$relatedProduct->name}}" class="img-fluid w-100">
                                        <a class="category" href="#">{{@$relatedProduct->category->name}}</a>
                                    </div>
                                    <div class="fp__menu_item_text">
                                        <p class="rating">
                                            @for($i=1; $i<=5; $i++)

                                                @if($i <= $relatedProduct->reviews_avg_rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="fal fa-star"></i>
                                                @endif

                                            @endfor
                                            <span>{{$relatedProduct->reviews_count}} </span>
                                        </p>
                                        <a class="title"
                                           href="{{route('product.show',$relatedProduct->slug)}}">{{$relatedProduct->name}}</a>
                                        <h5 class="price">

                                            @if($relatedProduct->offer_price > 0)
                                                {{currencyPosition($relatedProduct->price)}}
                                                <del>{{currencyPosition($relatedProduct->offer_price)}}</del>
                                            @else
                                                {{currencyPosition($relatedProduct->price)}}
                                            @endif


                                        </h5>
                                        <ul class="d-flex flex-wrap justify-content-center">
                                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#cartModal"><i
                                                        class="fas fa-shopping-basket"
                                                        onclick="loadProductModal('{{$relatedProduct->id}}')"></i></a>
                                            </li>
                                            <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                            <li><a href="#"><i class="far fa-eye"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        @endforeach


                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- CART POPUT START -->
    {{--<div class="fp__cart_popup">
        <div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                class="fal fa-times"></i></button>
                        <div class="fp__cart_popup_img">
                            <img src="images/menu1.png" alt="menu" class="img-fluid w-100">
                        </div>
                        <div class="fp__cart_popup_text">
                            <a href="#" class="title">Maxican Pizza Test Betterxxx</a>
                            <p class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="far fa-star"></i>
                                <span>(201)</span>
                            </p>
                            <h4 class="price">$320.00
                                <del>$350.00</del>
                            </h4>

                            <div class="details_size">
                                <h5>select size</h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="large01"
                                           checked>
                                    <label class="form-check-label" for="large01">
                                        large <span>+ $350</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="medium01">
                                    <label class="form-check-label" for="medium01">
                                        medium <span>+ $250</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="small01">
                                    <label class="form-check-label" for="small01">
                                        small <span>+ $150</span>
                                    </label>
                                </div>
                            </div>

                            <div class="details_extra_item">
                                <h5>select option <span>(optional)</span></h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="coca-cola01">
                                    <label class="form-check-label" for="coca-cola01">
                                        coca-cola <span>+ $10</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="7up01">
                                    <label class="form-check-label" for="7up01">
                                        7up <span>+ $15</span>
                                    </label>
                                </div>
                            </div>

                            <div class="details_quentity">
                                <h5>select quentity</h5>
                                <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                                    <div class="quentity_btn">
                                        <button class="btn btn-danger"><i class="fal fa-minus"></i></button>
                                        <input type="text" placeholder="1">
                                        <button class="btn btn-success"><i class="fal fa-plus"></i></button>
                                    </div>
                                    <h3>$320.00</h3>
                                </div>
                            </div>
                            <ul class="details_button_area d-flex flex-wrap">
                                <li><a class="common_btn v_submit_button" href="#">add to cartx</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
    <!-- CART POPUT END -->

    <!--=============================
        MENU DETAILS END
    ==============================-->
@endsection

{{--@push('scripts')

    <script>


        // Define the breakpoints with corresponding minimum widths
        const breakpoints = [
            { name: 'xs', width: 0 },
            { name: 'sm', width: 576 },
            { name: 'md', width: 768 },
            { name: 'lg', width: 992 },
            { name: 'xl', width: 1200 },
            { name: 'xxl', width: 1400 }
        ];

        // Function to get the current breakpoint based on the window width
        function getCurrentBreakpoint() {
            const width = window.innerWidth;
            console.log(breakpoints.slice().reverse().find(breakpoint => width >= breakpoint.width).name);
            return breakpoints.slice().reverse().find(breakpoint => width >= breakpoint.width).name;
        }

        // Store the initial breakpoint
        let currentBreakpoint = getCurrentBreakpoint();

        // Add event listener for window resize
        window.addEventListener('resize', function() {
            const newBreakpoint = getCurrentBreakpoint();
            if (newBreakpoint !== currentBreakpoint) {
                currentBreakpoint = newBreakpoint;
                location.reload();
            }
        });
    </script>
@endpush--}}
@push('scripts')
    <script>


        $(document).ready(function () {

            $('.v_product_size').prop('checked', false);
            $('.v_product_option').prop('checked', false);
            $('#v_quantity').val(1);


            $('.v_product_size').on("change", function () {
                v_updateTotalPrice();

            });

            $('.v_product_option').on("change", function () {
                v_updateTotalPrice();

            });

            let quantity = $('#v_quantity');
            let currentQuantity = parseFloat(quantity.val());

            $('.v_increment').on('click', function (e) {
                e.preventDefault();

                quantity.val(++currentQuantity);
                v_updateTotalPrice();
            })

            $('.v_decrement').on('click', function (e) {
                e.preventDefault();

                if (currentQuantity > 1) {
                    quantity.val(--currentQuantity);
                }
                v_updateTotalPrice();
            })


            $(document).on('click', '#reviews-pagination .pagination a', function (e) {
                e.preventDefault();

                var url = $(this).attr('href');
                fetchReviews(url);
                window.history.pushState("", "", url);
            });


        })
        function fetchReviews(url) {
            $.ajax({
                url : url
            }).done(function (data) {
                $('.articles').html(data);
            }).fail(function () {
                alert('Articles could not be loaded.');
            });
        }

        //Update the total price base on selected options
        function v_updateTotalPrice() {
            console.log('ok')
            let basePrice = parseFloat($('.v_base_price').val());
            let selectedSizePrice = 0;
            let selectedOptionsPrice = 0;
            let quantity = parseFloat($('#v_quantity').val());


            //calculate the selected size price
            let selectedSize = $('.v_product_size:checked');
            if (selectedSize.length > 0) {
                selectedSizePrice = parseFloat(selectedSize.data("price"))
            }

            //calculate  selected options  price
            let selectedOptions = $('.v_product_option:checked');
            console.log(selectedOptions)
            if (selectedOptions.length > 0) {
                $(selectedOptions).each(function () {
                    selectedOptionsPrice += parseFloat($(this).data("price"))
                    console.log(selectedOptionsPrice);
                })
            }

            //Calculate the total price
            let totalPrice = (basePrice + selectedSizePrice + selectedOptionsPrice) * quantity
            $('#v_total_price').text("{{config('settings.site_currency_icon')}}" + totalPrice)
        }


        $('.v_submit_button').on('click', function (e) {
            e.preventDefault();
            $('#v_add_to_cart_form').submit();
        })
        //Add to cart function
        $('#v_add_to_cart_form').on('submit', function (event) {
            event.preventDefault();

            //Validation
            let selectedSize = $('.v_product_size');
            if (selectedSize.length > 0) {
                if ($('.v_product_size:checked').val() === undefined) {
                    toastr.error("Please select a size")
                    console.error("Please select a size")
                    return
                }
            }

            let formData = $(this).serialize();

            $.ajax({
                method: 'post',
                url: '{{route("add-to-cart")}}',
                data: formData,
                beforeSend: function () {

                    $('.v_submit_button').attr('disabled', true);
                    $('.v_submit_button').html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true" ></span>&nbsp;&nbsp;&nbsp;Loading...')
                },

                success: function (response) {
                    updateSidebarCart()
                    toastr.success(response.message)
                },
                error: function (xhr, status, error) {
                    console.log(xhr)
                    let errorMessage = xhr.responseJSON.message;
                    toastr.error(errorMessage);
                },
                complete: function () {

                    $('.v_submit_button').html('Add to Cart');
                    $('.v_submit_button').attr('disabled', false);

                }
            })

        })
    </script>
@endpush
