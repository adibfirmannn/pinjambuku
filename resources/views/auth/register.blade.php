@extends('layouts.app')

@section('content')
    <div class="container register-container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card register-card">
                    <div class="row no-gutters">
                        <div class="col-md-6">
                            <div class="register-image"></div>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="card-body register-form">
                                <h2 class="register-title">{{ __('Register') }}</h2>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="form-group">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            placeholder="Email" value="{{ old('email') }}" required autocomplete="email"
                                            autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            placeholder="Password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" placeholder="Confirm Password" required
                                            autocomplete="new-password">
                                    </div>

                                    <div class="form-group text-center">
                                        <small class="text-muted">You Have account? <a href="{{ route('login') }}"
                                                class="">Login here</a></small>
                                    </div>
                                    <button type="submit" class="register-button btn-block">
                                        {{ __('Register') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
