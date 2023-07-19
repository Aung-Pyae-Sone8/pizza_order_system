@extends('admin.layouts.master')

@section('title', 'Category List Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>

                    </div>

                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin#changeStatus') }}" method="get">
                        @csrf
                        <div class="input-group mb-3 col-4">
                            <div class="input-group-append" title="Total">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-database mr-2"></i> {{ count($order) }}
                                </span>
                            </div>
                            <select name="orderStatus" class="custom-select" id="inputGroupSelect02">
                                <option value="">All</option>
                                <option value="0" @if (request('orderStatus') == '0') selected @endif>Pending</option>
                                <option value="1" @if (request('orderStatus') == '1') selected @endif>Accept</option>
                                <option value="2" @if (request('orderStatus') == '2') selected @endif>Reject</option>
                            </select>
                            <div class="input-group-append ms-1">
                                <button type="submit" class="btn btn-sm bg-dark text-white input-group-text">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> Search
                                </button>
                            </div>

                        </div>
                    </form>


                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Ordre Date</th>
                                    <th>Order Code</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($order as $o)
                                    <tr class="tr-shadow">
                                        <input type="hidden" class="orderId" value="{{ $o->id }}">
                                        <td class="">{{ $o->user_id }}</td>
                                        <td class="">{{ $o->user_name }}</td>
                                        <td class="">{{ $o->created_at->format('F-j-Y') }}</td>
                                        <td class="">
                                            <a href="{{ route('admin#listInfo', $o->order_code) }}">{{ $o->order_code }}</a>
                                        </td>
                                        <td class="">{{ $o->total_price }} Ks</td>
                                        <td class="">
                                            <select name="" id="" class="form-control statusChange">
                                                <option value="0" @if ($o->status == 0) selected @endif>
                                                    Pending
                                                </option>
                                                <option value="1" @if ($o->status == 1) selected @endif>
                                                    Accept
                                                </option>
                                                <option value="2" @if ($o->status == 2) selected @endif>
                                                    Reject
                                                </option>
                                            </select>
                                        </td>
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

@section('scriptSource')

    <script>
        $(document).ready(function() {
            // $('#orderStatus').change(function() {
            //     $status = $('#orderStatus').val();
            //     // $orderState = "";

            //     // switch ($status) {
            //     //     case '0':
            //     //         $orderState = 0;
            //     //         break;
            //     //     case '1':
            //     //         $orderState = 1;
            //     //         break;
            //     //     case '2':
            //     //         $orderState = 2;
            //     //         break;
            //     //     default:
            //     //         $orderState = "";
            //     //         break;
            //     // }

            //     $.ajax({
            //         type: 'get',
            //         url: 'http://localhost:8000/order/ajax/status',
            //         data: {
            //             'status': $status,
            //         },
            //         dataType: 'json',
            //         success: function(response) {


            //             $list = "";
            //             for ($i = 0; $i < response.length; $i++) {

            //                 $months = [
            //                     'January', 'February', 'March', 'April', 'May', 'June',
            //                     'August', 'September', 'October', 'November', 'December'
            //                 ];

            //                 console.log(response[$i].created_at);

            //                 $dbDate = new Date(response[$i].created_at);



            //                 $finalDate = $months[$dbDate.getMonth()] + "-" + $dbDate.getDate() +
            //                     "-" + $dbDate.getFullYear();

            //                 if (response[$i].status == 0) {
            //                     $statusMessage = `
        //                         <select name="" id="" class="form-control statusChange">
        //                             <option value="0" selected>Pending</option>
        //                             <option value="1" >Accept</option>
        //                             <option value="2">Reject</option>
        //                         </select>
        //                     `;
            //                 } else if (response[$i].status == 1) {
            //                     $statusMessage = `
        //                         <select name="" id="" class="form-control statusChange">
        //                             <option value="0">Pending</option>
        //                             <option value="1" selected>Accept</option>
        //                             <option value="2">Reject</option>
        //                         </select>
        //                     `;
            //                 } else if (response[$i].status == 2) {
            //                     $statusMessage = `
        //                         <select name="" id="" class="form-control statusChange">
        //                             <option value="0">Pending</option>
        //                             <option value="1" >Accept</option>
        //                             <option value="2" selected>Reject</option>
        //                         </select>
        //                     `;
            //                 }

            //                 $list += `
        //                 <tr class="tr-shadow">
        //                             <input type="hidden" class="orderId" value="${response[$i].id}">
        //                             <td class=""> ${response[$i] . user_id} </td>
        //                             <td class=""> ${response[$i] . user_name} </td>
        //                             <td class=""> ${$finalDate} </td>
        //                             <td class=""> ${response[$i] . order_code} </td>
        //                             <td class=""> ${response[$i] . total_price}  Ks</td>
        //                             <td class="">
        //                                 ${$statusMessage}
        //                             </td>
        //                         </tr>
        //             `;
            //             }
            //             $('#dataList').html($list);
            //         }
            //     })

            // })

            // change status
            $('.statusChange').change(function() {
                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $orderId = $parentNode.find('.orderId').val();

                $data = {
                    'orderId': $orderId,
                    'status': $currentStatus
                };

                console.log($data);

                $.ajax({
                    type: 'get',
                    url: 'http://localhost:8000/order/ajax/change/status',
                    data: $data,
                    dataType: 'json',
                })

            })
        })
    </script>

@endsection
