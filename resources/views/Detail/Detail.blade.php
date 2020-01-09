@extends('App') @section('head') @if($id == 404)
<meta http-equiv="refresh" content="1,URL={{ route('products') }}" />
@endif @endsection @section('title') Details @endsection @section('content')
@if($id != 404)
  @include('Detail.Mahlzeit')
@else
<br /><br /><br />
<p class="text-center">
    Diese Mahlzeit wurde nicht gefunden leite zurück, bitte warten ...
</p>
<br /><br /><br />
@endif @endsection
