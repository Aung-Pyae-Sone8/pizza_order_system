@extends('admin.layouts.master')

@section('title', 'Category List Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    {{-- <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>

                    </div> --}}

                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="table-responsive table-responsive-data2">

                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            @if ($user->image == null)
                                                @if ($user->gender == 'male')
                                                    <img src="{{ asset('image/male.png') }}" class="img-thumbnail shadow-sm" width="100px">
                                                @else
                                                    <img src="{{ asset('image/female.png') }}" class="img-thumbnail shadow-sm" width="100px">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $user->image) }}" alt="John Doe" class="img-thumbnail shadow-sm" width="100px" />
                                            @endif
                                        </td>
                                        <input type="hidden" id="userId" value="{{ $user->id }}">
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->gender }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>
                                            <select class="form-control statusChange">
                                                <option value="user" @if($user->role == 'user') selected @endif>User</option>
                                                <option value="admin" @if($user->role == 'admin') selected @endif>Admin</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $users->links() }}
                        </div>

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
            // change status
            $('.statusChange').change(function() {
                $currentStatus = $(this).val();

                $parentNode = $(this).parents("tr");
                $userId = $parentNode.find('#userId').val();

                // console.log($userId);
                $data = {
                    'userId': $userId,
                    'role' : $currentStatus
                };

                console.log($data);

                $.ajax({
                    type: 'get',
                    url: 'http://localhost:8000/user/change/role',
                    data: $data,
                    dataType: 'json',
                })
                location.reload();

            })
        })
    </script>

@endsection



