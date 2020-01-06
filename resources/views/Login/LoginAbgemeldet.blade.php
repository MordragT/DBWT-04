@extends('App')
@section('title') Login @endsection
@section('content')
<form method="POST" action="#">
    <fieldset class="offset-3 col-6">
        <legend>Login</legend>
        <label for="user" class="sr-only">Benutzer</label>
        <p><input id="user" name="user" placeholder="Benutzer" class="form-control"></p>
        <label for="password" class="sr-only">Passwort</label>
        <p><input id="password" type="password" name="password" placeholder="Passwort" class="form-control"></p>
        <p><input type="submit" class="btn btn-block" value="Anmelden"></p>
    </fieldset>
</form>
@endsection