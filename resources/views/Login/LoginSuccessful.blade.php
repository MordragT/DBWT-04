@extends('App') 
@section('title') Login @endsection
@section('content')
<br /><br />
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Login</div>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session("status") }}
                </div>
                @endif Du bist eingeloggt als {{ Auth::user()->Typ }}!
                <br /><br />
                <form
                    id="logout-form"
                    action="{{ route('logout') }}"
                    method="POST"
                >
                    @csrf
                    <button type="submit" class="btn">Abmelden</button>
                </form>
            </div>
        </div>
    </div>
</div>
<br /><br />
@endsection
