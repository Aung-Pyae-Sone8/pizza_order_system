{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    Hello I am admin category page

    <h3>Role - {{ Auth::user()->role }}</h3>

    <form action="{{ route('logout') }}" method="post">
        @csrf

        <input type="submit" value="Logout">
    </form>
</body>

</html> --}}

@extends('admin.layouts.master')

@section('title', 'Category List Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->


                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-3">
                            <h4 class="text-secondary">Search Key : <span class="text-info">{{request('key')}}</span></h4>
                        </div>

                        <div class="col-4 offset-5">
                            <form action="{{ route('admin#list') }}" method="GET">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" value="{{ request('key') }}" placeholder="Search...">
                                    <button type="submit" class="btn bg-dark text-white">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-1 offset-10 bg-white shadow-sm py-2 px-2 text-center">
                            <h4><i class="fa-solid fa-database" title="Total data"></i> - {{ $admin->total() }}</h4>
                        </div>
                    </div>
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
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admin as $a)
                                        <tr class="tr-shadow">
                                            <td class="col-1">
                                                @if ($a->image == null)
                                                    @if ($a->gender == 'male')
                                                        <img src="{{ asset('image/male.png') }}" alt="">
                                                    @else
                                                        <img src="{{ asset('image/female.png') }}" alt="">
                                                    @endif
                                                @else
                                                    <img src="{{ asset('storage/' . $a->image) }}" class="img-thumbnail shadow-sm">
                                                @endif
                                            </td>
                                            <td>{{ $a->name }}</td>
                                            <td>{{ $a->email }}</td>
                                            <td>{{ $a->gender }}</td>
                                            <td>{{ $a->phone }}</td>
                                            <td>{{ $a->address }}</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    @if (Auth::user()->id == $a->id)

                                                    @else
                                                        <a href="{{ route('admin#changeRole',$a->id) }}">
                                                            <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Change role">
                                                                <i class="fa-solid fa-person-circle-minus"></i>
                                                            </button>
                                                        </a>
                                                        <a href="{{ route('admin#delete',$a->id) }}">
                                                            <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                <i class="zmdi zmdi-delete"></i>
                                                            </button>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{ $admin->links() }}
                            </div>

                        </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
