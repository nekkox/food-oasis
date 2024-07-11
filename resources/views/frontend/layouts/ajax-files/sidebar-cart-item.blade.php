<input type="hidden" value="{{cartTotal()}}" id="cart_total">
<input type="hidden" value="{{count(Cart::content())}}" id="cart_product_count">

@foreach(Cart::content() as $cartProduct)
    <li>
        <div class="menu_cart_img">
            <img src="{{asset($cartProduct->options->product_info['image'])}}" alt="menu" class="img-fluid w-100">
        </div>
        <div class="menu_cart_text">
            <a class="title" href="{{route('product.show', $cartProduct->options->product_info['slug'])}}"> {{$cartProduct->name}} </a>
            <p class="size">Qty: {{$cartProduct->qty}}</p>
{{--            <p class="size">{{@$cartProduct->options['product_size']['name']}}</p>--}}
            <p class="size">{{@$cartProduct->options['product_size']['name']}} &nbsp; {{  @$cartProduct->options['product_size']['name'] ? '('.currencyPosition(@$cartProduct->options['product_size']['price']).')' : '' }}   </p>

            @foreach($cartProduct->options['product_options'] as $option)
{{--                <span class="extra">{{$option['name']}}</span>--}}
                <span class="extra">{{$option['name']}} &nbsp; ({{ currencyPosition(@$option['price'])  }}) </span>
            @endforeach

            <p class="price">
               {{currencyPosition($cartProduct->price)}}
            </p>
        </div>
        <span class="del_icon" onclick="removeProductFromSidebar('{{$cartProduct->rowId}}')"><i class="fal fa-times"></i></span>
    </li>
@endforeach

