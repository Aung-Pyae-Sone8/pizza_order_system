@extends('user.layouts.master')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cartList as $c)
                            <tr>
                                <td class="align-middle">
                                    <img src="{{ asset('storage/' . $c->pizza_image) }}" class="img-thumbnail" alt=""
                                        style="width: 50px;">
                                    {{ $c->pizza_name }}
                                    <input type="hidden" class="orderId" value="{{ $c->id }}">
                                    <input type="hidden" class="productId" value="{{ $c->product_id }}">
                                    <input type="hidden" class="userId" value="{{ $c->user_id }}">
                                </td>
                                <td class="align-middle" id="price">{{ $c->pizza_price }} Ks</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>

                                        <input type="text"
                                            class="form-control form-control-sm bg-secondary border-0 text-center"
                                            value="{{ $c->qty }}" id="qty">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle" id="total">{{ $c->pizza_price * $c->qty }} Ks</td>
                                <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove"><i
                                            class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subTotalPrice">{{ $totalPrice }} Ks</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery</h6>
                            <h6 class="font-weight-medium">3000 Ks</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalPrice">{{ $totalPrice + 3000 }} Ks</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id="orderBtn">
                            Proceed To Checkout
                        </button>

                        <button class="btn btn-block btn-danger font-weight-bold my-3 py-3" id="clearBtn">
                            Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('scriptSource')
    <script src="{{ asset('js/cart.js') }}"></script>
    <script>
        // order button

        $('#orderBtn').click(function() {

            $orderList = [];

            $random = Math.floor(Math.random() * 100000001);

            let today = new Date().toISOString().slice(0, 10);

            $('#dataTable tbody tr').each(function(index, row) {
                $orderList.push({
                    'user_id': $(row).find('.userId').val(),
                    'product_id': $(row).find('.productId').val(),
                    'qty': $(row).find('#qty').val(),
                    'total': $(row).find('#total').text().replace('Ks', '') * 1,
                    'order_code': 'POS' + $random
                })
            });

            $.ajax({
                type: 'get',
                url: 'http://localhost:8000/user/ajax/order',
                data: Object.assign({}, $orderList),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'true') {
                        window.location.href = 'http://localhost:8000/user/homePage';
                    }
                }
            })

        })

        // clear button

        $('#clearBtn').click(function() {
            $('#dataTable tbody tr').remove();
            $('#subTotalPrice').html("0 Ks");
            $('#finalPrice').html("0 Ks");

            $.ajax({
                type: 'get',
                url: 'http://localhost:8000/user/ajax/clear/cart',
                dataType: 'json'
            })
        })

        // when cross button click
        $(".btnRemove").click(function() {
            $parentNode = $(this).parents("tr");
            $productId = $parentNode.find(".productId").val();
            $orderId = $parentNode.find(".orderId").val();

            $.ajax({
                type: 'get',
                url: 'http://localhost:8000/user/ajax/clear/current/product',
                data: {
                    'productId': $productId,
                    'orderId': $orderId
                },
                dataType: 'json'
            })

            $parentNode.remove();
            $totalPrice = 0;
            $("#dataTable tbody tr").each(function(index, row) {
                $totalPrice += Number(
                    $(row).find("#total").text().replace("Ks", "")
                );
            });
            $("#subTotalPrice").html(`${$totalPrice} Ks`);
            $("#finalPrice").html(`${$totalPrice + 3000} Ks`);
        });
    </script>
@endsection
