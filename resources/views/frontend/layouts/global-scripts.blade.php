<script>

    /** Show Loader*/
    function showLoader(){
        $('.overlay-container').removeClass('d-none')
        $('.overlay').addClass('active')
    }

    /** Hide Loader*/

    function hideLoader(){
        $('.overlay').removeClass('active')
        $('.overlay-container').addClass('d-none')

    }

    function loadProductModal(productId) {
        $.ajax({
            method: "GET",
            url: '{{route("load-product-modal",":productId")}}'.replace(':productId', productId),
            beforeSend: function () {
                $('.overlay').addClass('active')
                $('.overlay-container').removeClass('d-none')
            },

            success: function (response) {
                $('.load_product_modal_body').html(response);
                $('#cartModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
            complete: function () {
                $('.overlay').removeClass('active')
                $('.overlay-container').addClass('d-none')
            }
        })
    }


    //Update Sidebar cart

    function updateSidebarCart(callback = null) {
        console.log('cart updated');
        $.ajax({
            method: "GET",
            url: '{{route('get-cart-products')}}',

            success: function (response) {
                $('.cart_contents').html(response);

                let cartTotal = $('#cart_total').val();
                let cartCount = $('#cart_product_count').val();

                $('.cart_subtotal').text("{{ currencyPosition(':cartTotal')}}".replace(':cartTotal', cartTotal));
                $('.cart_count').text(cartCount);

                if (callback && (typeof callback === 'function')) {
                    callback()
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
        })
    }

    //Remove product from sidebar cart
    function removeProductFromSidebar(rowId) {

        $.ajax({
            method: "GET",
            url: '{{route("cart-product-remove", ":rowId")}}'.replace(':rowId', rowId),
            beforeSend: function () {
                $('.overlay').addClass('active')
                $('.overlay-container').removeClass('d-none')
            },

            //Call updateSidebarCart function async when element is successfully removed
            success: function (response) {
                if (response.status === 'success') {
                    updateSidebarCart(function () {
                        setTimeout(() => {
                            toastr.success(response.message)
                            $('.overlay').removeClass('active')
                            $('.overlay-container').addClass('d-none')
                        }, 2000)
                    })
                }
            },
            error: function (xhr, status, error) {
                let errorMessage = xhr.responseJSON.message;
                toastr.error(errorMessage);
            },

        })
    }

    /** get current cart total amount*/
    function getCartTotal(){
        return parseInt("{{ cartTotal() }}");
    }

    $('body').on('click', '.delete-item', function(e){
        e.preventDefault();

        let url = $(this).attr('href');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'DELETE',
                    url: url,
                    data: {_token: "{{ csrf_token() }}"},
                    success: function(response) {
                        if(response.status === 'success'){
                            toastr.success(response.message)
                            window.location.reload();
                        }else if(response.status === 'error'){
                            toastr.error(response.message)
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                })
            }
        })
    })



    /** Add to wishlist**/
    function addToWishlist(productId){
        $.ajax({
            method: 'GET',
            url: '{{ route("wishlist.store", ":productId") }}'.replace(':productId', productId),
            beforeSend: function(){
                showLoader()
            },
            success: function(response){
                toastr.success(response.message);
            },
            error: function(xhr, status, error){
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(index, value) {
                    toastr.error(value);
                })
                hideLoader()
            },
            complete: function(){
                hideLoader()
            }
        })
    }


</script>
