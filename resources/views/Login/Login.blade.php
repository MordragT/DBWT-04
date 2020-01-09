@extends('App') @section('title') Login @endsection @section('content')
<br /><br />
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __("Login") }}</div>

            <div class="card-body">
                @include('Login.LoginForm')
            </div>
        </div>
    </div>
</div>
<br /><br />
@endsection
