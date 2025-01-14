@extends('frontend.layouts.master')

@section('content')

    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset(config('settings.breadcrumb')) }} );">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>cart view</h1>
                    <ul>
                        <li><a href="{{route('home')}}">home</a></li>
                        <li><a href="#">cart view</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        CART VIEW START
    ==============================-->
    <section class="fp__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                <tr>
                                    <th class="fp__pro_img">
                                        Image
                                    </th>

                                    <th class="fp__pro_name">
                                        details
                                    </th>

                                    <th class="fp__pro_status">
                                        price
                                    </th>

                                    <th class="fp__pro_select">
                                        quantity
                                    </th>

                                    <th class="fp__pro_tk">
                                        total
                                    </th>

                                    <th class="fp__pro_icon">
                                        <a class="clear_all" href="{{route("cart-destroy")}}">clear all</a>
                                    </th>
                                </tr>
                                @foreach(Cart::content() as $item)

                                    <tr class="product_row">
                                        <td class="fp__pro_img"><img
                                                src="{{asset($item->options['product_info']['image'])}}" alt="product"
                                                class="img-fluid w-100">
                                        </td>

                                        <td class="fp__pro_name">
                                            <a href="{{route('product.show', $item->options['product_info']['slug'])}}">{{$item->name}}</a>
                                            <span>

                                                @if( count($item->options['product_size']) > 0 )
                                                    <span style="color: red">
                                                            {{$item->options['product_size']['name']}}
                                                        ({{ currencyPosition($item->options['product_size']['price']) }})
                                                        </span>
                                                @endif

                                            </span>

                                            @if( count($item->options['product_options']) > 0 )
                                                @foreach($item->options['product_options'] as $option)
                                                    <span>{{$option['name'] .' ('. currencyPosition($option['price'])}})

                                                    </span>
                                                @endforeach
                                            @endif

                                        </td>

                                        <td class="fp__pro_status">
                                            <h6>{{ currencyPosition($item->price) }}</h6>
                                        </td>

                                        <td class="fp__pro_select">
                                            <div class="quentity_btn">
                                                <button class="btn btn-danger decrement"><i class="fal fa-minus"></i>
                                                </button>
                                                <input class="quantity" type="text" placeholder="1"
                                                       value="{{$item->qty}}" data-id="{{$item->rowId}}" readonly>
                                                <button class="btn btn-success increment"><i class="fal fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>

                                        <td class="fp__pro_tk">
                                            <h6 class="product_cart_total">{{currencyPosition(productTotal($item->rowId))}}</h6>
                                        </td>

                                        <td class="fp__pro_icon remove_cart_product" data-id="{{$item->rowId}}">
                                            <a href="#"><i class="far fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if(Cart::content()->count() === 0)
                                    <tr>
                                        <td colspan="6" class="text-center fp__pro_name"
                                            style="width: 100%; display: inline">Cart is Empty
                                        </td>
                                    </tr>
                                @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list_footer_button">
                        <h6>total cart</h6>
                        <p>subtotal: <span id="subtotal">{{currencyPosition(cartTotal())}}</span></p>
                        <p>delivery: <span> {{ config('settings.site_currency_icon') }}00.00</span></p>
                        <p>discount: <span id="discount">

                                 @if (isset(session()->get('coupon')['discount']))
                                    {{ config('settings.site_currency_icon') }} {{ session()->get('coupon')['discount'] }}
                                @else
                                    {{ config('settings.site_currency_icon') }}0
                                @endif

                            </span></p>

                        <p class="total"><span>total:</span> <span id="final_total">
                            @if (isset(session()->get('coupon')['discount']))
                                    {{ config('settings.site_currency_icon') }} {{ cartTotal() - session()->get('coupon')['discount'] }}
                                @else
                                    {{ config('settings.site_currency_icon') }} {{ cartTotal() }}
                                @endif
                        </span></p>

                        <form id="coupon_form">
                            <input type="text" id="coupon_code" name="code" placeholder="Coupon Code">
                            <button type="submit" id="coupon_btn">apply</button>
                        </form>

                        <div class="coupon_card">
                        @if(session()->has('coupon'))

                                <div class="card mt-2">
                                    <div class="m-3">
                                        <span><b class="v_coupon_code">Applied Couppon: {{ session()->get('coupon')['code'] }}</b></span>
                                        <span>
                                    <button id="destroy_coupon"><i class="far fa-times"></i></button>
                                </span>
                                    </div>
                                </div>


                        @endif
                        </div>

                        <a class="common_btn" href="{{route('checkout.index')}}">checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        CART VIEW END
    ==============================-->

@endsection


@push('scripts')
    <script>
        $(document).ready(function () {

            var cartTotal = parseInt("{{ cartTotal() }}");

            $('.increment').on('click', function () {
                let inputFiend = $(this).siblings('.quantity')
                let currentValue = parseInt(inputFiend.val());
                let rowId = inputFiend.data('id')

                inputFiend.val(currentValue + 1)

                cartQtyUpdate(rowId, inputFiend.val(), function (response) {

                    if (response.status === 'success') {
                        inputFiend.val(response.qty);

                        let productTotal = response.product_total;
                        // Update the total for this product
                        inputFiend.closest('.product_row')
                            .find('.product_cart_total')
                            .text("{{ currencyPosition(":productTotal") }}"
                                .replace(':productTotal', productTotal))

                        cartTotal = response.cart_total;
                        $('#subtotal').text("{{ config('settings.site_currency_icon') }}" + cartTotal);
                        $("#final_total").text("{{ config('settings.site_currency_icon') }}" + response.grand_cart_total)

                    } else if (response.status === 'error') {
                        toastr.error(response.message)
                        inputFiend.val(response.qty)
                    }


                })
            })

            $('.decrement').on('click', function () {
                let inputFiend = $(this).siblings('.quantity')
                let currentValue = parseInt(inputFiend.val());
                let rowId = inputFiend.data('id');

                if (inputFiend.val() > 1) {
                    inputFiend.val(currentValue - 1)
                    cartQtyUpdate(rowId, inputFiend.val(), function (response) {
                        console.log(response)
                        if (response.status === 'success') {
                            inputFiend.val(response.qty);
                            let productTotal = response.product_total;
                            // Update the total for this product
                            inputFiend.closest('.product_row')
                                .find('.product_cart_total')
                                .text("{{ currencyPosition(":productTotal") }}"
                                    .replace(':productTotal', productTotal))

                            cartTotal = response.cart_total;
                            $('#subtotal').text("{{ config('settings.site_currency_icon') }}" + cartTotal);
                            $("#final_total").text("{{ config('settings.site_currency_icon') }}" + response.grand_cart_total)

                        } else if (response.status === 'error') {
                            toastr.error(response.message);
                        }
                    })
                }
            })


            function cartQtyUpdate(rowId, qty, callback) {
                $.ajax({
                    method: 'post',
                    url: '{{route('cart.quantity-update')}}',
                    data: {
                        rowId: rowId,
                        qty: qty
                    },
                    beforeSend: function () {
                        showLoader();
                    },
                    success: function (response) {
                        if (response && typeof callback === 'function') {
                            callback(response)
                        }
                    },
                    error: function (xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        hideLoader();
                        toastr.error(errorMessage);

                    },
                    complete: function () {
                        setTimeout(function () {
                            hideLoader();
                        }, 1000)
                    }
                })
            }


            $('.remove_cart_product').on('click', function (e) {
                e.preventDefault();
                let rowId = $(this).data('id')
                removeCartProduct(rowId);
                $(this).closest('tr').remove()
            })

            function removeCartProduct(rowId) {
                $.ajax({
                    method: 'GET',
                    url: '{{route("cart-product-remove", ":rowId")}}'.replace(':rowId', rowId),
                    beforeSend: function () {
                        showLoader();

                    },
                    success: function (response) {
                        updateSidebarCart()

                        cartTotal = response.cart_total;
                        $('#subtotal').text("{{ config('settings.site_currency_icon') }}" + cartTotal);
                        $("#final_total").text("{{ config('settings.site_currency_icon') }}" + response.grand_cart_total)

                    },
                    error: function (xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        hideLoader();
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        setTimeout(function () {
                            hideLoader();
                        }, 1000)
                    }
                })
            }

            $('.clear_all').on('click', function () {
                destroyCart()
            })

            function destroyCart() {
                $.ajax({
                    method: 'GET',
                    url: '{{route("cart-destroy")}}',
                    beforeSend: function () {
                        showLoader();

                    },
                    success: function (response) {
                        updateSidebarCart()
                    },
                    error: function (xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        hideLoader();
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        setTimeout(function () {
                            hideLoader();
                        }, 1000)
                    }
                })
            }

            //Getting data from coupon form
            $('#coupon_form').on('submit', function (e) {
                e.preventDefault();
                let code = $('#coupon_code').val();
                let subtotal = cartTotal;

                couponApply(code, subtotal)
            })


            /* function updateSubtotal(){
                 alert(getCartTotal())
                 $('#subtotal').text("{{ config('settings.site_currency_icon') }}" + getCartTotal());
            }*/


            function couponApply(code, subtotal) {
                $.ajax({
                    method: 'post',
                    url: '{{route('apply-coupon')}}',
                    data: {
                        code: code,
                        subtotal: subtotal
                    },
                    beforeSend: function () {
                        showLoader()
                    },
                    success: function (response) {
                        $("#coupon_code").val("");
                        $('#discount').text("{{ config('settings.site_currency_icon') }}" + response.discount);
                        $('#final_total').text("{{ config('settings.site_currency_icon') }}" + response.finalTotal);

                        $couponCartHtml = `<div class="card mt-2">
                            <div class="m-3">
                                <span><b class="v_coupon_code">Applied Couppon: ${response.coupon_code}</b></span>
                                <span>
                                    <button id="destroy_coupon"><i class="far fa-times"></i></button>
                                </span>
                            </div>
                        </div>`

                        $('.coupon_card').html($couponCartHtml);
                        toastr.success('Coupon applied successfully');
                    },
                    error: function (xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        hideLoader()
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        hideLoader()
                    }
                })
            }

            $(document).on('click', "#destroy_coupon", function(){
                destroyCoupon();
            });

            function destroyCoupon(){
                $.ajax({
                    method: 'GET',
                    url: '{{ route("destroy-coupon") }}',
                    beforeSend: function(){
                        showLoader();
                    },
                    success: function(response){
                        $('#discount').text("{{ config('settings.site_currency_icon') }}"+0);
                        $("#final_total").text("{{ config('settings.site_currency_icon') }}" + response.grand_cart_total);
                        $('.coupon_card').html("");
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error){
                        let errorMessage = xhr.responseJSON.message;
                        hideLoader()
                        toastr.error(errorMessage);
                    },
                    complete: function(){
                        hideLoader();
                    }
                })
            }

        })
    </script>
@endpush
