@extends('App') @section('head')
<meta http-equiv="refresh" content="30,URL={{ route('home') }}" />
@endsection @section('title') Registrierung @endsection @section('content')
<br /><br />
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Registrierung</div>

            <div class="card-body">
                <p class="text-center">
                    Herzlichen Glückwunsch sie haben sich erfolgreich
                    registriert! Ihre ID: {{ $id }}
                </p>
            </div>
        </div>
    </div>
</div>
<br /><br />
@endsection
