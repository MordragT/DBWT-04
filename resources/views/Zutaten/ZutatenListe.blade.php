<table class="table">
    <thead class="thead-dark">
        <tr>
            <th class="w-25" scope="col">Name</th>
            <th class="w-25" scope="col">Vegan</th>
            <th class="w-25" scope="col">Vegetarisch</th>
            <th class="w-25" scope="col">Glutenfrei</th>
        </tr>
    </thead>
    @foreach ($zutaten as $zutat)
    <tbody>
        <tr>
            <td>
                <form
                    action="http://google.de/search"
                    method="get"
                    target="”_blank”"
                >
                    <span title="Suchen Sie nach {{ $zutat->Name }} im Web">
                        <input
                            type="hidden"
                            name="q"
                            value="{{ $zutat->Name }}"
                        />
                        <button class="table-button" type="submit">
                            {{ $zutat->Name }}
                            @if ($zutat->Bio)
                            <img height="30" src="@asset('img/bio.png')" alt="Bio" />
                            @endif
                        </button></span>
                </form>
            </td>
            @if ($zutat->Vegan)
            <td><i class="fa fa-check"></i></td>
            @else
            <td><i class="fa fa-times"></i></td>
            @endif
            @if ($zutat->Vegetarisch)
            <td><i class="fa fa-check"></i></td>
            @else
            <td><i class="fa fa-times"></i></td>
            @endif
            @if ($zutat->Glutenfrei)
            <td><i class="fa fa-check"></i></td>
            @else
            <td><i class="fa fa-times"></i></td>
            @endif
        </tr>
    </tbody>
    @endforeach
</table>
