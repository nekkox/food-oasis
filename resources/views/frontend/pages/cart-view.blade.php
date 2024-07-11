@extends('frontend.layouts.master')

@section('content')

    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{asset('frontend/images/counter_bg.jpg')}});">
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
                        <p>subtotal: <span>$124.00</span></p>
                        <p>delivery: <span>$00.00</span></p>
                        <p>discount: <span>$10.00</span></p>
                        <p class="total"><span>total:</span> <span>$134.00</span></p>
                        <form>
                            <input type="text" placeholder="Coupon Code">
                            <button type="submit">apply</button>
                        </form>
                        <a class="common_btn" href=" #">checkout</a>
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
            $('.increment').on('click', function () {
                let inputFiend = $(this).siblings('.quantity')
                let currentValue = parseInt(inputFiend.val());
                let rowId = inputFiend.data('id')

                inputFiend.val(currentValue + 1)

                cartQtyUpdate(rowId, inputFiend.val(), function (response) {
                    console.log(response)
                    if (response.status === 'success') {
                        inputFiend.val(response.qty)
                        let productTotal = response.product_total;
                        // Update the total for this product
                        inputFiend.closest('.product_row')
                            .find('.product_cart_total')
                            .text("{{ currencyPosition(":productTotal") }}"
                                .replace(':productTotal', productTotal))
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


        })
    </script>
@endpush
