@extends('user.layouts.master')

@section('content')
    <section>
        <div class="col-4 offset-4">
            <form action="{{ route('user#contact') }}" method="POST">
                @csrf
                <label for="name">Name</label>
                <input type="text" name="name" placeholder="Enter your name..." class="form-control">
                <label for="email" class="mt-3">Email</label>
                <input type="email" name="email" placeholder="Enter your email..." class="form-control">
                <label for="message" class="mt-3">Message</label>
                <textarea name="message" id="" cols="30" rows="10" class="form-control" placeholder="Enter message..."></textarea>
                <input type="submit" value="Send" class="btn btn-dark text-white mt-3">
            </form>
        </div>
    </section>
@endsection
