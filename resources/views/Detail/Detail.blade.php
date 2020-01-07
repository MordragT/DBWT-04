@extends('App') 
@section('head') @if($id == 404)
<meta http-equiv="refresh" content="1,URL=/produkte" />
@endif @endsection
@section('title') Details @endsection
@section('content')
@if($id != 404)
<div class="row mt-4">
  <div class="col-3 pt-5">
    @if($_SESSION['loginstatus'] == 'angemeldet')
    <p>
      Hallo <i>{{$_SESSION['user']}}</i>, Sie sind angemeldet als 
      <strong>{{$_SESSION['typ']}}</strong>
    </p>
    <form method="POST" action="#">
      <input type="hidden" name="logout" value="true">
      <input type="submit" class="btn btn-block" value="Abmelden">
    </form>
    @elseif($_SESSION['loginstatus'] =='loginfehler') 
    <p class="text-danger">Das hat nicht geklappt, bitte versuchen sie es erneut!</p>
    <form method="POST" action="#">
        <fieldset>
            <legend>Login</legend>
            <label for="user" class="sr-only">Benutzer</label>
            <p><input id="user" name="user" placeholder="Benutzer" value="{{$_SESSION['user']}}" class="form-control alert-danger text-danger"></p>
            <label for="password" class="sr-only">Passwort</label>
            <p><input id="password" type="password" name="password" placeholder="Passwort" class="form-control alert-danger"></p>
            <p><input type="submit" class="btn btn-block" value="Anmelden"></p>
        </fieldset>
    </form>
    @else
    <form method="POST" action="#">
        <fieldset>
            <legend>Login</legend>
            <label for="user" class="sr-only">Benutzer</label>
            <p><input id="user" name="user" placeholder="Benutzer" class="form-control"></p>
            <label for="password" class="sr-only">Passwort</label>
            <p><input id="password" type="password" name="password" placeholder="Passwort" class="form-control"></p>
            <p><input type="submit" class="btn btn-block" value="Anmelden"></p>
        </fieldset>
    </form>
    @endif
  </div>
  <div class="col-6">
    <h2>Details für {{ $produkt->Name }}</h2>
    <img
      src="data:image/gif;base64,{{ base64_encode($produkt->Binärdaten) }}"
      class="rounded img-fluid"
      alt="{//{ $produkt->Alt-Text }}"
    />
  </div>
  <div class="col-3">
    <div class="row justify-content-end">
      <div class="col-6 mb-4">
        <br />
        @if(isset($_SESSION['typ']) and $_SESSION['typ'] == 'Studierender')
        <p>
          <strong>{{ $_SESSION["typ"] }}</strong
          >-Preis
        </p>
        <h2>{{$produkt->Studierendenpreis}}€</h2>
        @elseif(isset($_SESSION['typ']) and $_SESSION['typ'] == 'Mitarbeiter')
        <p>
          <strong>{{ $_SESSION["typ"] }}</strong
          >-Preis
        </p>
        <h2>{{$produkt->Mitarbeiterpreis}}€</h2>
        @else
        <p><strong>Gast</strong>-Preis</p>
        <h2>{{$produkt->Gastpreis}}€</h2>
        @endif
        <br />
      </div>
      <div class="col-12 pt-5">
        <form>
          <input type="hidden" name="produkt" value="falafel" />
          <button type="submit" class="btn btn-block">
            <i class="fa fa-cutlery"></i> Vorbestellen
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row mt-5">
  <div class="col-3">
    <p>
      Melden Sie sich jetzt an, um die wirklich viel günstigeren Preise für
      Mitarbeiter oder Studenten zu sehen.
    </p>
  </div>
  <div class="col-6 border rounded">
    <ul
      class="nav nav-tabs justify-content-center mt-3"
      id="myTab"
      role="tablist"
    >
      <li class="nav-item">
        <a
          class="nav-link active link"
          id="beschr-tab"
          data-toggle="tab"
          href="#beschr"
          role="tab"
          aria-controls="beschr"
          aria-selected="true"
          >Beschreibung</a
        >
      </li>
      <li class="nav-item">
        <a
          class="nav-link link"
          id="zutaten-tab"
          data-toggle="tab"
          href="#zutaten"
          role="tab"
          aria-controls="zutaten"
          aria-selected="false"
          >Zutaten</a
        >
      </li>
      <li class="nav-item">
        <a
          class="nav-link link"
          id="bew-tab"
          data-toggle="tab"
          href="#bew"
          role="tab"
          aria-controls="bew"
          aria-selected="false"
          >Bewertungen</a
        >
      </li>
    </ul>
    <div class="tab-content rounded p-3" id="myTabContent">
      <div
        class="tab-pane fade show active"
        id="beschr"
        role="tabpanel"
        aria-labelledby="beschr-tab"
      >
        <p>{{ $produkt->Beschreibung }}</p>
      </div>
      <div
        class="tab-pane fade"
        id="zutaten"
        role="tabpanel"
        aria-labelledby="zutaten-tab"
      >
        @include ('Zutaten.ZutatenListe')
      </div>
      <div
        class="tab-pane fade"
        id="bew"
        role="tabpanel"
        aria-labelledby="bew-tab"
      >
      <!--http://bc5.m2c-lab.fh-aachen.de/form.php-->
        <form action="#" method="post">
          @csrf
          <fieldset>
            <legend class="text-center mb-3">Mahlzeit bewerten</legend>
            <div class="row mr-3 mb-4">
              <label class="col-4" for="mahlzeit">Mahlzeit:</label>
              <select class="form-control col-8" id="mahlzeit" name="mahlzeit">
                <option>Falafel</option>
              </select>
            </div>
            <div class="row mb-4 mr-3">
              <label class="col-4" for="benutzer">Benutzername:</label>
              <input
                type="text"
                id="benutzer"
                name="benutzer"
                class="col-8 form-control"
              />
            </div>
            <div class="row mb-4 mr-3">
              <label class="col-4" for="bewertung">Bewertung:</label>
              <input
                type="number"
                class="form-control col-8"
                max="5"
                min="1"
                name="bewertung"
                id="bewertung"
              />
            </div>
            <div class="row mb-4 mr-3">
              <label class="col-4" for="bemerkung">Bemerkung:</label>
              <textarea
                id="bemerkung"
                name="bemerkung"
                placeholder="Geben Sie eine Bemerkung ein, wenn sie möchten..."
                class="form-control col-8"
              ></textarea>
            </div>
            <div class="row mb-4 mr-3 justify-content-end">
              <input
                type="submit"
                class="btn col-8"
                value="comment"
              />
            </div>
            <input type="hidden" name="matrikel" value="3193955" />
            <input type="hidden" name="kontrolle" value="mar" />
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
@else
<br><br><br>
<p class="text-center">Diese Mahlzeit wurde nicht gefunden leite zurück, bitte warten ...</p>
<br><br><br>
@endif
@endsection
