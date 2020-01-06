@extends('App')
@section('title') Login @endsection
@section('content')
<p class="text-danger offset-3 col-6">Das hat nicht geklappt, bitte versuchen sie es erneut!</p>
<form method="POST" action="#" class="offset-3 col-6">
    <fieldset>
        <legend>Login</legend>
        <label for="user" class="sr-only">Benutzer</label>
        <p><input id="user" name="user" placeholder="Benutzer" value="{{$_SESSION['user']}}" class="form-control alert-danger text-danger"></p>
        <label for="password" class="sr-only">Passwort</label>
        <p><input id="password" type="password" name="password" placeholder="Passwort" class="form-control alert-danger"></p>
        <p><input type="submit" class="btn btn-block" value="Anmelden"></p>
    </fieldset>
</form>
@endsection