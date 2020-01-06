@extends('App')
@section('head')
<meta http-equiv="refresh" content="30,URL=?url=" />
@endsection
@section('title') Registrierung @endsection
@section('content')
<br><br><br>
<p class="text-center">Herzlichen Glückwunsch sie haben sich erfolgreich registriert! Deine ID: {{ $_SESSION['new_id']}}</p>
<br><br><br>
@endsection