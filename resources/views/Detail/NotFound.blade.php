@extends('App') @section('head')
<meta http-equiv="refresh" content="1,URL={{ route('products') }}" />
@endsection @section('title') Details @endsection @section('content')
<br /><br /><br />
<p class="text-center">
    Diese Mahlzeit wurde nicht gefunden leite zurück, bitte warten ...
</p>
<br /><br /><br />
@endsection
