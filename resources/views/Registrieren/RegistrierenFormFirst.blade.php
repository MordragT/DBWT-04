@extends('App') @section('title') Registrierung @endsection @section('content')
<br /><br />
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Registrierung</div>
            <div class="card-body">
                <form
                    method="POST"
                    action="{{ route('register.first.submit') }}"
                >
                    @csrf
                    <fieldset>
                        <div class="row form-group">
                            <label
                                for="benutzername"
                                class="col-md-4 col-form-label text-md-right"
                                >Nickname</label
                            >
                            <div class="col-md-6">
                                <input
                                    title="Bitte mindestens 4 Zeichen"
                                    pattern=".{4,}"
                                    id="benutzername"
                                    name="Benutzername"
                                    class="form-control @error('Benutzername') is-invalid @enderror"
                                    type="text"
                                    value="{{ old('Benutzername') }}"
                                    required
                                />
                                @error('Benutzername')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <label
                                for="password"
                                class="col-md-4 col-form-label text-md-right"
                                >Passwort</label
                            >
                            <div class="col-md-6">
                                <input
                                    title="Bitte mindestens 4 Zeichen, 1 Sonderzeichen, 1 Nummer und 1 Buchstabe"
                                    pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{4,}$"
                                    id="password"
                                    name="password"
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    required
                                />
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <label
                                for="password_confirmation"
                                class="col-md-4 col-form-label text-md-right"
                                >Passwort</label
                            >
                            <div class="col-md-6">
                                <input
                                    title="Bitte mindestens 4 Zeichen, 1 Sonderzeichen und eine Nummer"
                                    pattern="^(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{4,}$"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    class="form-control"
                                    required
                                />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label
                                for="mitarbeiter"
                                class="col-md-4 col-form-label text-md-right"
                                >Was tun Sie ?</label
                            >
                            <div class="col-md-6 form-check" id="options">
                                <div>
                                    <input
                                        type="checkbox"
                                        id="mitarbeiter"
                                        name="Mitarbeiter"
                                    />
                                    <label
                                        for="mitarbeiter"
                                        class="form-check-label"
                                        >Ich arbeite an der FH</label
                                    >
                                </div>
                                <div>
                                    <input
                                        type="checkbox"
                                        id="student"
                                        name="Student"
                                    />
                                    <label
                                        for="student"
                                        class="form-check-label"
                                        >Ich studiere an der FH</label
                                    >
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn">
                                Registrierung fortsetzen
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
