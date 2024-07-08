<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
        class="fal fa-times"></i></button>
<form id="model_add_to_cart_form" action="">


    <input type="hidden" name="product_id" value="{{$product->id}}">
    <div class="fp__cart_popup_img">
        <img src="{{asset($product->thumb_image)}}" alt="menu" class="img-fluid w-100">
    </div>
    <div class="fp__cart_popup_text">
        <a href="{{route('product.show', $product->slug)}}" class="title">{{$product->name}}</a>
        <p class="rating">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
            <i class="far fa-star"></i>
            <span>(201)</span>
        </p>
        <h4 class="price">
            @if($product->offer_price > 0)
                <input type="hidden" name="base_price" value="{{$product->offer_price}}">
                {{currencyPosition($product->offer_price)}}
                <del>{{currencyPosition($product->price)}}</del>
            @else
                <input type="hidden" name="base_price" value="{{$product->price}}">
                {{currencyPosition($product->price)}}
            @endif
        </h4>


        {{--PRODUCT SIZES--}}
        @if($product->productSizes()->exists())
            <div class="details_size">
                <h5>select size</h5>
                @foreach($product->productSizes as $ProductSize)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="{{$ProductSize->id}}"
                               data-price="{{$ProductSize->price}}" name="product_size"
                               id="size-{{$ProductSize->id}}">
                        <label class="form-check-label" for="size-{{$ProductSize->id}}">
                            {{$ProductSize->name}} <span>+ {{currencyPosition($ProductSize->price)}}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        @endif


        {{--PRODUCT OPTIONS--}}
        @if($product->productOptions()->exists())
            <div class="details_extra_item">
                <h5>select option <span>(optional)</span></h5>
                @foreach($product->productOptions as $productOption)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="product_option[]"
                               value="{{$productOption->id}}" id="option-{{$productOption->name}}"
                               data-price="{{$productOption->price}}"
                        >
                        <label class="form-check-label" for="option-{{$productOption->name}}">
                            {{$productOption->name}} <span>+ {{currencyPosition($productOption->price)}}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        @endif


        <div class="details_quentity">
            <h5>select quentity</h5>
            <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                <div class="quentity_btn">
                    <button class="btn btn-danger decrement"><i class="fal fa-minus"></i></button>
                    <input type="text" placeholder="1" value="1" id="quantity" name="quantity" readonly>
                    <button class="btn btn-success increment"><i class="fal fa-plus"></i></button>
                </div>
                <h3 id="total_price">
                    @if($product->offer_price > 0)
                        {{currencyPosition($product->offer_price)}}
                    @else
                        {{currencyPosition($product->price)}}
                    @endif
                </h3>
            </div>
        </div>
        <ul class="details_button_area d-flex flex-wrap">

            <li>
                <button type="submit" class="common_btn">add to cart</button>
            </li>
        </ul>

    </div>
</form>

<script>
    $(document).ready(function () {
        $("input[name='product_size']").on("change", function () {
            updateTotalPrice();
        });

        $("input[name='product_option[]']").on("change", function () {
            updateTotalPrice();
        });

        let quantity = $('#quantity');
        let currentQuantity = parseFloat(quantity.val());

        $('.increment').on('click', function (e) {
            e.preventDefault();

            quantity.val(++currentQuantity);
            updateTotalPrice();
        })

        $('.decrement').on('click', function (e) {
            e.preventDefault();

            if (currentQuantity > 1) {
                quantity.val(--currentQuantity);
            }
            updateTotalPrice();
        })

        $('#model_add_to_cart_form').on('submit', function (event) {
            event.preventDefault();

            //Validation
            let selectedSize = $('input[name="product_size"]');

            if (selectedSize.length > 0) {
                let checked = $('input[name="product_size"]:checked');
                if (checked.val() === undefined) {
                    toastr.error("Please select a size")
                    return
                }
            }

            let formData = $(this).serialize();

            $.ajax({
                method: 'post',
                url: '{{route('add-to-cart')}}',
                data: formData,
                success: function (response) {
                    toastr.success(response.message)
                },
                error: function (xhr, status, error) {
                    let errorMessage = xhr.responseJSON.message;
                    toastr.error(errorMessage);
                }
            })

        })
    });


    //Update the total price base on selected options
    function updateTotalPrice() {
        let basePrice = parseFloat($('input[name="base_price"]').val());
        let selectedSizePrice = 0;
        let selectedOptionsPrice = 0;
        let quantity = parseFloat($('#quantity').val());


        //calculate the selected size price
        let selectedSize = $('input[name="product_size"]:checked');
        if (selectedSize.length > 0) {
            selectedSizePrice = parseFloat(selectedSize.data("price"))
        }

        //calculate  selected options  price
        let selectedOptions = $('input[name="product_option[]"]:checked');
        console.log(selectedOptions)
        if (selectedOptions.length > 0) {
            $(selectedOptions).each(function () {
                selectedOptionsPrice += parseFloat($(this).data("price"))
            })
        }

        //Calculate the total price
        let totalPrice = (basePrice + selectedSizePrice + selectedOptionsPrice) * quantity
        $('#total_price').text("{{config('settings.site_currency_icon')}}" + totalPrice)

    }

</script>
