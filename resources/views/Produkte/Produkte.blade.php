@extends('App') 
@section('title') Produkte @endsection
@section('content')
<div class="row my-5 pr-5">
  <div class="col-3 bg-light align-items-center justify-content-center rounded">
    <form method="GET">
      <fieldset class="my-3 px-3">
        <legend class="text-center my-3">
          Speisenliste filtern
        </legend>
        <label for="kategorie" class="sr-only">Kategorien</label>
        <select id="kategorie" name="kat" class="form-control">
          @foreach($optGroups as $optGroup)
          <optgroup label="{{ $optGroup->Bezeichnung }}">
            @foreach($optGroup->options as $option) 
            @if($kat == $option->ID)
            <option
              value="{{ $option->ID }}"
              selected
              >{{ $katname = $option->Bezeichnung }}</option
            >
            @else
            <option
              value="{{ $option->ID }}"
              >{{ $option->Bezeichnung }}</option
            >
            @endif 
            @endforeach
          </optgroup>
          @endforeach
        </select>
        <div class="my-3 ml-5">
          <p>
            @if($avail == true)
            <input
              type="checkbox"
              class="form-check-input"
              name="avail"
              id="verfuegbar"
              checked
            />
            @else
            <input
              type="checkbox"
              class="form-check-input"
              name="avail"
              id="verfuegbar"
            />
            @endif
            <label class="form-check-label" for="verfuegbar"
              >nur verfügbare</label
            >
          </p>
          <p>
            @if($vegetarisch)
            <input
              type="checkbox"
              class="form-check-input"
              name="vegetarisch"
              id="vegetarisch"
              checked
            />
            @else
            <input
              type="checkbox"
              class="form-check-input"
              name="vegetarisch"
              id="vegetarisch"
            />
            @endif
            <label class="form-check-label" for="vegetarisch"
              >nur vegetarische</label
            >
          </p>
          <p>
            @if($vegan)
            <input
              type="checkbox"
              class="form-check-input"
              name="vegan"
              id="vegan"
              checked
            />
            @else
            <input
              type="checkbox"
              class="form-check-input"
              name="vegan"
              id="vegan"
            />
            @endif
            <label class="form-check-label" for="vegan">nur vegan</label>
          </p>
        </div>
        <div>
          <button
            type="submit"
            class="btn btn-block"
            name="url"
            value="produkte"
          >
            Speisen filtern
          </button>
        </div>
      </fieldset>
    </form>
  </div>
  <div class="col-8 offset-1">
    <h2 class="text-center my-4">Verfügbare Speisen ({{ $katname }})</h2>
    <div class="row">
      @include('Produkte.ProdukteElemente')
    </div>
  </div>
</div>
@endsection