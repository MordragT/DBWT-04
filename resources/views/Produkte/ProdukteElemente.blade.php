@foreach($produkte as $produkt)
@if (($kat == 3 or $kat == $produkt->Kategorie)
and (($avail == true and $produkt->Verfügbar == true) || $avail == false)
and (($vegetarisch == true and $produkt->Vegetarisch == null) || $vegetarisch == false)
and (($vegan == true and $produkt->Vegan == null) || $vegan == false))
@php
$limitCount++;
@endphp
<div class="col-3 p-3">
    <div class="card shadow">
        <img
            src="data:image/gif;base64,{{ base64_encode($produkt->Binärdaten) }}"
            class="card-img-top img-fluid"
            alt="{//{ $produkt->Alt-Text }}"
        />
        @if ($produkt->Verfügbar)
        <div class="card-body text-center alert-info">
            <p class="card-title">{{ $produkt->Name }}</p>
            <a href="/detail&id={{ $produkt->ID }}" class="btn-link link"
                >Details</a>
        </div>
        @else
        <div class="card-body text-center alert-secondary">
            <p class="card-title">{{ $produkt->Name }}</p>
            <a
                href="/detail&id={{ $produkt->ID }}"
                class="btn-link link disabled"
                >Vergriffen</a>
        </div>
        @endif
    </div>
</div>
@endif
@if ($limitCount >= $limit)
@break
@endif
@endforeach
@if($limitCount == 0)
<p>Leider wurden keine passenden Mahlzeiten gefunden.</p>
@endif
