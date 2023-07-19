@extends('admin.layouts.master')

@section('title', 'Category List Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="row">
            <div class="col-3 offset-7 mb-2">
                @if (session('updateSuccess'))
                        <div class="">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark"></i> {{ session('updateSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
            </div>
        </div>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                {{-- <div class="row">
                    <div class="col-3 offset-8">
                        <a href="{{ route('category#list') }}"><button class="btn bg-dark text-white my-3">List</button></a>
                    </div>
                </div> --}}
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="ms-3">
                                <i class="fa-solid fa-arrow-left text-dark" onclick="history.back()"></i>
                            </div>
                            <div class="card-title">

                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-3 offset-1">
                                    <img src="{{ asset('storage/'.$pizza->image) }}" class="img-thumbnail shadow-sm">
                                </div>
                                <div class="col-8">
                                    <h3 class="my-1 fs-4 btn btn-danger bg-gradient d-block w-50 text-center"><i class="fa-solid fs-4 fa-pizza-slice me-2"></i>{{ $pizza->name }}</h3>
                                    <span class="btn bg-dark text-white my-3"><i class="fa-solid fs-4 fa-coins me-2"></i>{{ $pizza->price }} Ks</span>
                                    <span class="btn bg-dark text-white my-3"><i class="fa-solid fs-4 fa-clock me-2"></i>{{ $pizza->waiting_time }} mins</span>
                                    <span class="btn bg-dark text-white my-3"><i class="fa-solid fs-4 fa-eye me-2"></i>{{ $pizza->view_count }}</span>
                                    <span class="btn bg-dark text-white my-3"><i class="fa-solid fa-list-check me-2" title="category"></i>{{ $pizza->category_name }}</span>
                                    <span class="btn bg-dark text-white my-3"><i class="fa-solid fs-4 fa-user-clock me-2"></i>{{ $pizza->created_at->format('j-F-Y') }}</span>
                                    <div class="my-3"><i class="fa-solid fs-4 fa-file-lines me-2"></i>Details</div>
                                    <div class="">{{ $pizza->description }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
