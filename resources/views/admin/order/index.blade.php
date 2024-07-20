@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Orders</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Orders</h4>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="order_modal" tabindex="-1" role="dialog" aria-labelledby="order_modal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="">Order Status</label>
                            <select class="form-control order_status" name="order_status" id="">
                                <option value="pending">Pending</option>
                                <option value="in_process">In Process</option>
                                <option value="delivered">Delivered</option>
                                <option value="declined">Declined</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Payment Status</label>
                            <select class="form-control payment_status" name="payment_status" id="">
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        $(document).ready(function(){
            $(document).on('click', '.order_status_btn', function(){
                let id = $(this).data('id');
                let paymentStatus = $('.payment_status');
                let orderStatus = $('.order_status');
                let defaultPaymentStatus = 'default_payment_status_value'; // Set the default value for payment status
                let defaultOrderStatus = 'default_order_status_value'; // Set the default value for order status

                function checkPaymentStatus(response, item){
                    return new Promise((resolve) => {
                        if(item.val() === response.payment_status){
                            item.prop('selected', true);
                            resolve(true);
                        } else {
                            resolve(false);
                        }
                    });
                }

                function checkOrderStatus(response, item){
                    return new Promise((resolve) => {
                        if(item.val() === response.order_status){
                            item.prop('selected', true);
                            resolve(true);
                        } else {
                            resolve(false);
                        }
                    });
                }

                $.ajax({
                    method: 'GET',
                    url: '{{route("admin.orders.status", ":id")}}'.replace(":id", id),
                    success: function(response) {
                        console.log(response);

                        let paymentMatched = false;
                        let orderMatched = false;

                        // Check and process paymentStatus options
                        paymentStatus.find('option').each(function() {
                            checkPaymentStatus(response, $(this))
                                .then(result => {
                                    if (result) {
                                        paymentMatched = true;
                                    }
                                })
                                .catch(error => console.error('Error in Payment Status:', error))
                                .finally(() => {
                                    if (!paymentMatched) {
                                        paymentStatus.val(defaultPaymentStatus);
                                    }
                                });
                        });

                        // Check and process orderStatus options
                        orderStatus.find('option').each(function() {
                            checkOrderStatus(response, $(this))
                                .then(result => {
                                    if (result) {
                                        orderMatched = true;
                                    }
                                })
                                .catch(error => console.error('Error in Order Status:', error))
                                .finally(() => {
                                    if (!orderMatched) {
                                        orderStatus.val(defaultOrderStatus);
                                    }
                                });
                        });
                    },
                    error: function(xhr, status, error){
                        console.error('AJAX Error:', status, error);
                    },
                    complete: function(){
                        console.log('AJAX Request Completed');
                    }
                });
            });
        });


    </script>
@endpush
