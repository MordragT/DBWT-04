@extends('App')
@section('title') Registierung @endsection
@section('content')
<div class="my-4">
@if(!empty($error))
<fieldset class="error offset-3">
  <legend>Es gab Fehler beim Bearbeiten Ihrer Anfrage:</legend>
  <ul>
    @foreach($error as $err)
    <li>{{ $err }}</li>
    @endforeach
  </ul>
</fieldset>
@endif
<form method="POST" action="?url=registrieren" class="my-4">
  <fieldset>
    <legend class="offset-3">Ihre Benutzerdaten</legend>
    <div class="row my-2">
      <label for="vorname" class="col-2 offset-3">Vorname</label>
      <input id="vorname" name="reg-vorname" class="form-control col-4" value="{{ $vorname or '' }}" required/>
    </div>
    <div class="row my-2">
      <label for="nachname" class="col-2 offset-3">Nachname</label>
      <input id="nachname" name="reg-nachname" class="form-control col-4" value="{{ $nachname or '' }}" required/>
    </div>
    <div class="row my-2">
      <label for="email" class="col-2 offset-3">E-Mail</label>
      <input
        id="email"
        name="reg-email"
        type="email"
        @if(!isset($error['email']))
        class="form-control col-4"
        @else
        class="form-control col-4 is-invalid"
        @endif
        value="{{ $email or '' }}"
        required
      />
    </div>
    <div class="row my-2">
      <label for="geburtsdatum" class="col-2 offset-3">Geburtsdatum</label>
      <input
        id="geburtsdatum"
        name="reg-geburtsdatum"
        type="date"
        class="form-control col-4"
        value="{{ $geburtsdatum or '' }}"
      />
    </div>
  </fieldset>
@if($student != null or $mitarbeiter != null)
  <fieldset>
    <legend class="offset-3">Ihr Fachbereich</legend>
    <div class="row my-2">
      <label for="fachbereiche" class="col-2 offset-3"
        >Welchem Fachbereich gehören Sie an ?</label
      >
      <select class="form-control col-4" id="fachbereiche" name="reg-fachbereich">
        @foreach($fachbereiche as $opt)
        <option>{{ $opt->Name }}</option>
        @endforeach
      </select>
    </div>
  </fieldset>
  @endif
  @if($student != null)
  <fieldset>
    <legend class="offset-3">Ihre Daten als Student</legend>
    <div class="row my-2">
      <label for="matrikelnummer" class="col-2 offset-3">Matrikelnummer</label>
      <input
        id="matrikelnummer"
        name="reg-matrikelnummer"
        type="number"
        @if(!isset($error['matrikelnummer']))
        class="form-control col-4"
        @else
        class="form-control col-4 is-invalid"
        @endif
        value="{{ $matrikelnummer or '' }}"
        required
      />
    </div>
    <div class="row">
      <select
        class="form-control col-4 offset-5"
        id="studiengaenge"
        name="reg-studiengang"
      >
        @foreach($studiengaenge as $opt)
        <option>{{ $opt }}</option>
        @endforeach
      </select>
    </div>
  </fieldset>
  @elseif($mitarbeiter != null)
  <fieldset>
    <legend class="offset-3">Ihre Daten als Mitarbeiter</legend>
    <div class="row my-2">
      <label for="telefon" class="col-2 offset-3">Telefon</label>
      <input
        id="telefon"
        name="reg-telefon"
        type="text"
        value="{{ $telefon or '' }}"
        class="col-4 form-control"
        required
      />
    </div>
    <div class="row my-2">
      <label for="büro" class="col-2 offset-3">Büro</label>
      <input
        id="büro"
        name="reg-büro"
        type="text"
        pattern="{,4}"
        class="col-4 form-control"
        value="{{ $büro or '' }}"
        required
      />
    </div>
  </fieldset>
  @endif
  <input type="hidden" name="page" value="success">
  <input type="hidden" name="reg-benutzername" value="{{ $benutzername }}">
  <input type="hidden" name="final-passwort" value="{{ $passwort }}">
  <input type="hidden" name="mitarbeiter" value="{{ $mitarbeiter }}">
  <input type="hidden" name="student" value="{{ $student }}">
  <div class="row my-2">
    <input type="submit" class="btn btn-block col-6 offset-3" value="Senden" />
  </div>
</form>
</div>
@endsection