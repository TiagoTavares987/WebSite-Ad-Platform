<form class="form-inline col-md-6" action="{{ route('ads.search') }}" method="POST">
    @csrf
    <div class="input-group">
        <input id="search" name="search" class="form-control" type="search" placeholder="Search" aria-label="Search" value="{{ $search->text }}">
        <div class="input-group-text">
            @if ($search->searchDescription)
                <input id="searchDescription" name="searchDescription" class="form-check-input mt-0" type="checkbox" data-toggle="tooltip" data-placement="bottom" title="pesquisar na descrição" checked>
            @else
                <input id="searchDescription" name="searchDescription" class="form-check-input mt-0" type="checkbox" data-toggle="tooltip" data-placement="bottom" title="pesquisar na descrição">
            @endif
        </div>                            
        <button type="submit" class="btn btn-outline-success input-group-text">Search</button>
    </div>
</form>