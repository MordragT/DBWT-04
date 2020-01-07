@extends('App') 
@section('title') e-Mensa @endsection 
@section('content')
<div class="row mb-2 justify-content-center">
  <div class="col w-100">
    <img
      class="rounded img-fluid w-100"
      src="img/banner.png"
      alt="Banner-Test"
    />
  </div>
</div>
<div class="row mb-5 mt-5">
  <div class="col-3">
    <div class="row">
      <div class="col-12 pb-5">
        <p>
          Der Dienst e-Mensa is noch beta. Sie können bereits
          <a href="/produkte" class="link">Mahlzeiten</a>
          durchstöbern, aber noch nicht bestellen.
        </p>
      </div>
      <div class="col-12">
        <p>
          Registrieren Sie sich
          <a href="/registrieren" class="link">hier</a>
          um Über die Veröffentlichung des Dienstes per Mail informiert zu
          werden.
        </p>
      </div>
    </div>
  </div>
  <div class="col-9">
    <div class="row">
      <div class="col-9">
        <h2>
          Leckere Gerichte vorbestellen
          {{ date('h:i') }}
        </h2>
        <p>... und gemeinsam mit Kommilitonen und Freunden essen</p>
      </div>
      <div class="col-3 pb-5 py-2">
        <a class="btn btn-block" href="/registrieren" role="button">
          <i class="fa fa-hand-o-right"></i> Registrieren
        </a>
        <br />
        <a class="btn btn-block" href="/login" role="button">
          <i class="fa fa-sign-in"></i> Anmelden
        </a>
      </div>
      <div class="col-12">
        <img
          src="img/placeholder-banner.png"
          alt="Placeholder"
          class="rounded img-fluid"
        />
      </div>
    </div>
  </div>
</div>
@endsection
