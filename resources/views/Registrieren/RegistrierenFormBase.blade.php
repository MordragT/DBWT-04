@extends('App')
@section('title') Registrierung @endsection
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
  <form method="POST" action="?url=registrieren">
    <fieldset>
      <legend class="offset-3">Ihre Registrierung</legend>
      <div class="row my-2">
        <label for="reg-benutzername" class="col-2 offset-3">Nickname</label>
        <input
          title="Bitte mindestens 4 Zeichen"
          pattern=".{4,}"
          id="reg-benutzername"
          name="reg-benutzername"
          @if(!isset($error['benutzername']))
          class="form-control col-4"
          @else
          class="form-control col-4 is-invalid"
          @endif
          type="text"
          value="{{ $benutzername or '' }}"
          required
        />
      </div>
      <div class="row my-2">
        <label for="reg-passwort" class="col-2 offset-3">Passwort</label>
        <input
          title="Bitte mindestens 4 Zeichen, 1 Sonderzeichen, 1 Nummer und 1 Buchstabe"
          pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{4,}$"
          id="reg-passwort"
          name="reg-passwort"
          type="password"
          @if(!isset($error['passwort']))
          class="form-control col-4"
          @else
          class="form-control col-4 is-invalid"
          @endif
          required
        />
      </div>
      <div class="row my-2">
        <label for="reg-passwort-w" class="col-2 offset-3">Passwort</label>
        <input
          title="Bitte mindestens 4 Zeichen, 1 Sonderzeichen und eine Nummer"
          pattern="^(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{4,}$"
          id="reg-passwort-w"
          name="reg-passwort-w"
          type="password"
          @if(!isset($error['passwort']))
          class="form-control col-4"
          @else
          class="form-control col-4 is-invalid"
          @endif
          required
        />
      </div>
      <div class="row my-2">
        <label
          for="reg-mitarbeiter"
          @if(!isset($error['typ']))
          class="col-2 offset-3"
          @else
          class="col-2 offset-3 is-invalid"
          @endif
          >Was tun Sie ?</label>
        <div id="reg-typ">
          <!--
          <div>
            <input 
              type="checkbox"
              id="reg-gast"
              name="gast"
              value="gast"
            />
            <label for="reg-mitarbeiter">Ich bin ein Gast</label>
          </div>
          -->
          <div>
            <input
              type="checkbox"
              id="reg-mitarbeiter"
              name="mitarbeiter"
              value="mitarbeiter"
            />
            <label for="reg-mitarbeiter">Ich arbeite an der FH</label>
          </div>
          <div>
            <input
              type="checkbox"
              id="reg-student"
              name="student"
              value="student"
            />
            <label for="reg-student">Ich studiere an der FH</label>
          </div>
        </div>
      </div>
    </fieldset>
    <input type="hidden" name="page" value="next">
    <div class="row my-2">
      <input
        type="submit"
        class="btn btn-block col-6 offset-3"
        value="Registrierung fortsetzen"
        name="reg-fortsetzen"
      />
    </div>
  </form>
</div>
@endsection
