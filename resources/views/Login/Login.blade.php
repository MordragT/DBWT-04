@extends('App') @section('title') Login @endsection @section('content')
<br /><br />
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __("Login") }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <div class="form-group row">
                        <label
                            for="benutzername"
                            class="col-md-4 col-form-label text-md-right"
                            >{{ __("Benutzername") }}</label
                        >

                        <div class="col-md-6">
                            <input
                                id="benutzername"
                                type="text"
                                class="form-control @error('Benutzername') is-invalid @enderror"
                                name="Benutzername"
                                value="{{ old('Benutzername') }}"
                                required
                                autocomplete="benutzername"
                                autofocus
                            />

                            @error('Benutzername')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label
                            for="password"
                            class="col-md-4 col-form-label text-md-right"
                            >{{ __("Passwort") }}</label
                        >

                        <div class="col-md-6">
                            <input
                                id="password"
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                required
                                autocomplete="current-password"
                            />

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn">
                                {{ __("Login") }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br /><br />
@endsection
