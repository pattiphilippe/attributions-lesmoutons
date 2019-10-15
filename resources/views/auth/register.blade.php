@extends('layouts.loginLayout')

@section('content')
    <form class="form-signin" method="POST" action="{{ route('register') }}">
        @csrf

        <img class="mb-4" src="{{ asset('images/he2b-esi.jpg') }}" alt="icone de l'ecole" width="175" height="120">
        <h1 class="h3 mb-3 font-weight-normal">Please register</h1>

        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email address" required>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="inputConfirmPassword" class="sr-only">Confirm Password</label>
        <input type="password" id="inputConfirmPassword" name="password_confirmation" class="form-control last-input" placeholder="Confirm Password" required>
        {{-- <div class="checkbox mb-3">
            <label>
            <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div> --}}
        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
        <a class="btn btn-lg btn-info btn-block" href="/" role="button">Sign in</a>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
    </form>
@endsection
