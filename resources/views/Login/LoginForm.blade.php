<form method="POST" action="{{ route('login.submit') }}">
    @csrf

    <div class="form-group row">
        @if(Route::currentRouteName() == 'login')
        <label
            for="benutzername"
            class="col-md-4 col-form-label text-md-right"
            >{{ __("Benutzername") }}</label
        >
        @endif
        <div @if(Route::currentRouteName() == 'login') class="col-md-6" @endif>
            <input
                id="benutzername"
                type="text"
                class="form-control @error('Benutzername') is-invalid @enderror"
                name="Benutzername"
                value="{{ old('Benutzername') }}"
                @if(Route::currentRouteName() == 'details') placeholder="Benutzername" @endif
                required
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
        @if(Route::currentRouteName() == 'login')
        <label
            for="password"
            class="col-md-4 col-form-label text-md-right"
            >{{ __("Passwort") }}</label
        >
        @endif
        <div @if(Route::currentRouteName() == 'login') class="col-md-6" @endif>
            <input
                id="password"
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                name="password"
                @if(Route::currentRouteName() == 'details') placeholder="Passwort" @endif
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
        <div @if(Route::currentRouteName() == 'login') class="col-md-8 offset-md-4" @endif>
            <button type="submit" class="btn">
                {{ __("Login") }}
            </button>
        </div>
    </div>
</form>