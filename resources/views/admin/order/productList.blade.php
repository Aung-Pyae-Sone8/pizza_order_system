@extends('admin.layouts.master')

@section('title', 'Category List Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->

                    <div class="table-responsive table-responsive-data2">
                        <a href="{{ route('admin#orderList') }}" class="btn btn-dark text-white"><i
                                class="fa-solid fa-arrow-left-long me-2">
                                Back</i></a>

                        {{-- <div class="card mt-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col"><i class="fa-solid fa-user me-2"></i>Customer Name</div>
                                    <div class="col">Aung</div>
                                </div>
                                <div class="row"></div>
                            </div>
                        </div> --}}

                        <div class="row col-5">

                            <div class="card mt-4">
                                <div class="card-body">
                                    <h3>Order Info</h3>
                                    <small class="text-warning mt-3"><i class="fa-solid fa-triangle-exclamation"></i>Inclute Delivery Charges</small>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-solid fa-user me-2"></i>Customer Name</div>
                                        <div class="col">{{ strtoupper($orderList[0]->user_name) }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-solid fa-barcode me-2"></i>Order Code</div>
                                        <div class="col">{{ $orderList[0]->order_code }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-solid fa-clock me-2"></i>Order Date</div>
                                        <div class="col">{{ $orderList[0]->created_at->format('F-j-Y') }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-solid fa-money-bill-wave me-2"></i>Total</div>
                                        <div class="col">{{ $order->total_price }} Ks</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    {{-- <th>User Name</th> --}}
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Ordre Date</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($orderList as $o)
                                    <tr class="tr-shadow">
                                        <td class="">{{ $o->id }}</td>
                                        {{-- <td>{{ $o->user_name }}</td> --}}
                                        <td><img src="{{ asset('storage/' . $o->product_image) }}" class="img-thumbnail"
                                                style="width:100px;">
                                        </td>
                                        <td>{{ $o->product_name }}</td>
                                        <td class="">{{ $o->created_at->format('F-j-Y') }}</td>
                                        <td>{{ $o->qty }}</td>
                                        <td class="">{{ $o->total }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- <div class="mt-3">
                            {{ $order->links() }}
                            {{ $categories->appends(request()->query())->links() }}
                        </div> --}}

                    </div>

                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
