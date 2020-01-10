@extends('App') @section('title') Details @endsection @section('content')
<div class="row mt-4">
    <div class="col-3 pt-5">
        @if(Auth::check())
        <p>Du bist eingeloggt als {{ Auth::user()->Typ }}!</p>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn">Abmelden</button>
        </form>
        @else @include('Login.LoginForm') @endif
    </div>
    <div class="col-6">
        <h2>Details für {{ $mahlzeit->Name }}</h2>
        <img
            src="data:image/gif;base64,{{ base64_encode($mahlzeit->bilder->Binärdaten) }}"
            class="rounded img-fluid"
            alt="{{ $mahlzeit->bilder->{'Alt-Text'} }}"
        />
    </div>
    <div class="col-3">
        <div class="row justify-content-end">
            <div class="col-6 mb-4">
                <br />
                @if(Auth::check() and Auth::user()->Typ == 'Studierender')
                <p>
                    <strong>{{ Auth::user()->Typ }}</strong
                    >-Preis
                </p>
                <h2>{{ $mahlzeit->preis->Studentpreis }}€</h2>
                @elseif(Auth::check() and Auth::user()->Typ == 'Mitarbeiter')
                <p>
                    <strong>{{ Auth::user()->Typ }}</strong
                    >-Preis
                </p>
                <h2>{{ $mahlzeit->preis->{'MA-Preis'} }}€</h2>
                @else
                <p><strong>Gast</strong>-Preis</p>
                <h2>{{ $mahlzeit->preis->Gastpreis }}€</h2>
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
            Melden Sie sich jetzt an, um die wirklich viel günstigeren Preise
            für Mitarbeiter oder Studenten zu sehen.
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
                <p>{{ $mahlzeit->Beschreibung }}</p>
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
                @if(Auth::check() && Auth::user()->Typ == 'Studierender')
                <!--http://bc5.m2c-lab.fh-aachen.de/form.php-->
                <form action="{{ route('comment.submit', $id) }}" method="post">
                    @csrf
                    <fieldset>
                        <legend class="text-center mb-3">
                            Mahlzeit bewerten
                        </legend>
                        <div class="row mb-4 mr-3">
                            <label class="col-4" for="bewertung"
                                >Bewertung:</label
                            >
                            <input
                                type="number"
                                class="form-control col-8"
                                max="5"
                                min="1"
                                name="bewertung"
                                id="bewertung"
                                required
                            />
                        </div>
                        <div class="row mb-4 mr-3">
                            <label class="col-4" for="bemerkung"
                                >Bemerkung:</label
                            >
                            <textarea
                                id="bemerkung"
                                name="bemerkung"
                                placeholder="Geben Sie eine Bemerkung ein, wenn sie möchten..."
                                class="form-control col-8"
                            ></textarea>
                        </div>
                        <div class="row mb-4 mr-3 justify-content-end">
                            <button type="submit" class="btn col-8">
                                Kommentieren
                            </button>
                        </div>
                        <!--input type="hidden" name="matrikel" value="3193955" />
                        <input type="hidden" name="kontrolle" value="mar" /-->
                    </fieldset>
                </form>
                @else
                <p>
                    Bitte loggen Sie sich als Student ein um Bewertungen
                    abzugeben.
                </p>
                @endif
                <strong>Durchschnittsbewertung für {{ $mahlzeit->Name }}: {{ $mahlzeit->Bewertung }}</strong>
                <br><br>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Benutzer/Datum</th>
                            <th scope="col">Bewertung/Bemerkung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kommentare as $kommentar)
                        <tr>
                            <td scope="row">
                                <p>{{ $kommentar->student->angehöriger->benutzer->Benutzername }}</p>
                                <p>{{ date('d.m.Y',strtotime($kommentar->Zeitpunkt)) }}</p>
                            </td>
                            <td>
                                <p>
                                @for($i = 0; $i < $kommentar->Bewertung; $i++)
                                    <i class="fa fa-star"></i>
                                @endfor
                                </p>
                                <p class="d-inline-block text-truncate" style="max-width: 300px;">{{ $kommentar->Bemerkung }}</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
