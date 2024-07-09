<script>
    function loadProductModal(productId){

        $.ajax({
            method: "GET",
            url: '{{route("load-product-modal",":productId")}}'.replace(':productId', productId),
            beforeSend: function(){
                $('.overlay').addClass('active')
                $('.overlay-container').removeClass('d-none')

            },

            success: function(response){

            $('.load_product_modal_body').html(response);
            $('#cartModal').modal('show');
            },
            error: function(xhr, status, error){
                console.log(error);
            },
            complete: function(){
                $('.overlay').removeClass('active')
                $('.overlay-container').addClass('d-none')
            }
        })
    }


    //Update Sidebar cart

    function updateSidebarCart(){

        $.ajax({
            method: "GET",
            url: '{{route('get-cart-products')}}',
            beforeSend: function(){

            },

            success: function(response){
            $('.cart_contents').html(response);
                let cartTotal = $('#cart_total').val();
                $('.cart_subtotal').text("{{ currencyPosition(':cartTotal')}}".replace(':cartTotal',cartTotal));
            },
            error: function(xhr, status, error){
                console.log(error);
            },
            complete: function(){

            }
        })
    }
</script>
