@extends('user.layouts.master')

@section('content')
    <div class="row">
        <div class="col-6 offset-3">
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        {{-- <div class="row">
                            <div class="col-3 offset-8">
                                <a href="{{ route('category#list') }}"><button class="btn bg-dark text-white my-3">List</button></a>
                            </div>
                        </div> --}}
                        <div class="">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h3 class="text-center title-2">Change Password</h3>
                                    </div>
                                    @if (session('changeSuccess'))
                                        <div class="col-12">
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa-solid fa-circle-check"></i> {{ session('changeSuccess') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        </div>
                                    @endif

                                    @if (session('notMatch'))
                                        <div class="col-12">
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <i class="fa-solid fa-circle-xmark"></i> {{ session('notMatch') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        </div>
                                    @endif
                                    <hr>
                                    <form action="{{ route('user#changePassword') }}" method="post" novalidate="novalidate">
                                        @csrf
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Old Password</label>
                                            <input id="cc-pament" name="oldPassword" type="password" class="form-control @error('oldPassword') is-invalid @enderror" aria-required="true" aria-invalid="false">
                                            @error('oldPassword')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">New Password</label>
                                            <input id="cc-pament" name="newPassword"
                                                type="password" class="form-control @error('newPassword') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false">
                                            @error('newPassword')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Confirm Password</label>
                                            <input id="cc-pament" name="confirmPassword"
                                                type="password" class="form-control @error('confirmPassword') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false">
                                            @error('confirmPassword')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div>
                                            <button id="payment-button" type="submit" class="btn btn-lg btn-dark text-white rounded btn-block">
                                                <i class="fa-solid fa-key me-2"></i><span id="payment-button-amount">Change Password</span>
                                                {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                                            </button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
