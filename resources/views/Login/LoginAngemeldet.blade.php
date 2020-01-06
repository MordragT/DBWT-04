@extends('App')
@section('title') Login @endsection
@section('content')
<p class="offset-3 col-6">
    Hallo <i>{{$_SESSION['user']}}</i>, Sie sind angemeldet als 
    <strong>{{$_SESSION['typ']}}</strong>
</p>
<p>
    <form method="POST" action="#" class="offset-3 col-6">
        <input type="hidden" name="logout" value="true">
        <input type="submit" class="btn btn-block" value="Abmelden">
    </form>
</p>
@endsection
