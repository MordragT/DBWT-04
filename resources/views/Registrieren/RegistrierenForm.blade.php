@extends('App') @section('title') Registierung @endsection @section('content')
<br /><br />
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Registrierung</div>

            <div class="card-body">
                <form
                    method="POST"
                    action="{{ route('register.last.submit') }}"
                >
                    @csrf
                    <fieldset>
                        <legend>Registrierung</legend>
                        <div class="row form-group">
                            <label
                                for="vorname"
                                class="col-md-4 col-form-label text-md-right"
                                >Vorname</label
                            >
                            <div class="col-md-6">
                                <input
                                    id="vorname"
                                    name="Vorname"
                                    class="form-control @error('Vorname') is-invalid @enderror"
                                    value="{{ old('Vorname') }}"
                                    required
                                />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label
                                for="nachname"
                                class="col-md-4 col-form-label text-md-right"
                                >Nachname</label
                            >
                            <div class="col-md-6">
                                <input
                                    id="nachname"
                                    name="Nachname"
                                    class="form-control @error('Nachname') is-invalid @enderror"
                                    value="{{ old('Nachname') }}"
                                    required
                                />
                            </div>
                        </div>

                        <div class="row form-group">
                            <label
                                for="email"
                                class="col-md-4 col-form-label text-md-right"
                                >Email</label
                            >
                            <div class="col-md-6">
                                <input
                                    id="email"
                                    name="Email"
                                    type="email"
                                    class="form-control @error('Email') is-invalid @enderror"
                                    value="{{ old('Email') }}"
                                    required
                                />
                                @error('Email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <label
                                for="geburtsdatum"
                                class="col-md-4 col-form-label text-md-right"
                                >Geburtsdatum</label
                            >
                            <div class="col-md-6">
                                <input
                                    id="geburtsdatum"
                                    name="Geburtsdatum"
                                    type="date"
                                    class="form-control @error('Geburtsdatum') is-invalid @enderror"
                                    value="{{ old('Geburtsdatum') }}"
                                />
                            </div>
                        </div>
                    </fieldset>
                    @if($mitarbeiter or $student)
                    <fieldset>
                        <legend>Ihr Fachbereich</legend>
                        <div class="row form-group">
                            <label
                                for="fachbereiche"
                                class="col-md-4 col-form-label text-md-right"
                                >Welchem Fachbereich gehören Sie an ?</label
                            >
                            <div class="col-md-6">
                                <select
                                    class="form-control @error('Fachbereiche') is-invalid @enderror"
                                    id="fachbereiche"
                                    name="Fachbereich"
                                >
                                    @foreach($fachbereiche as $opt)
                                    <option>{{ $opt->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    @endif @if($student)
                    <fieldset>
                        <legend>Ihre Daten als Student</legend>
                        <div class="row form-group">
                            <label
                                for="matrikelnummer"
                                class="col-md-4 col-form-label text-md-right"
                                >Matrikelnummer</label
                            >
                            <div class="col-md-6">
                                <input
                                    id="matrikelnummer"
                                    name="Matrikelnummer"
                                    type="number"
                                    class="form-control @error('Matrikelnummer') is-invalid @enderror"
                                    value="{{ old('Matrikelnummer') }}"
                                    required
                                />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label
                                for="studiengang"
                                class="col-md-4 col-form-label text-md-right"
                                >Studiengänge</label
                            >
                            <div class="col-md-6">
                                <select
                                    class="form-control @error('Studiengang') is-invalid @enderror"
                                    id="studiengang"
                                    name="Studiengang"
                                >
                                    @foreach($studiengaenge as $opt)
                                    <option>{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    @endif @if($mitarbeiter)
                    <fieldset>
                        <legend>
                            Ihre Daten als Mitarbeiter
                        </legend>
                        <div class="row form-group">
                            <label
                                for="telefon"
                                class="col-md-4 col-form-label text-md-right"
                                >Telefon</label
                            >
                            <div class="col-md-6">
                                <input
                                    id="telefon"
                                    name="Telefon"
                                    type="text"
                                    value="{{ old('Telefon') }}"
                                    class="form-control @error('Telefon') is-invalid @enderror"
                                    required
                                />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label
                                for="büro"
                                class="col-md-4 col-form-label text-md-right"
                                >Büro</label
                            >
                            <div class="col-md-6">
                                <input
                                    id="büro"
                                    name="Büro"
                                    type="text"
                                    pattern="{,4}"
                                    class="form-control @error('Büro') is-invalid @enderror"
                                    value="{{ old('Büro') }}"
                                    required
                                />
                            </div>
                        </div>
                    </fieldset>
                    @endif @if(!$mitarbeiter and !$student)
                    <fieldset>
                        <legend>
                            Ihre Daten als Gast
                        </legend>
                        <div class="row form-group">
                            <label
                                for="grund"
                                class="col-md-4 col-form-label text-md-right"
                                >Grund</label
                            >
                            <div class="col-md-6">
                                <textarea
                                    id="grund"
                                    name="Grund"
                                    rows="3"
                                    class="form-control @error('Grund') is-invalid @enderror"
                                    required
                                  >{{ old('Grund') }}</textarea>
                            </div>
                        </div>
                    </fieldset>
                    @endif

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn">
                                Registrierung abschließen
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
