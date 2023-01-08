<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="padding-top: 4px;padding-bottom: 4px;">
                    <nav class="navbar navbar-expand-md .navbar-light justify-content-between" style="padding-top: 0px;padding-bottom: 0px;">
                        <div class="container">
                            <span>{{ __('Products') }}</span>
                            <div id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true" v-pre="">
                                            <img src="{{ asset('storage/images/sort.png') }}" width="20" height="20">
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" data-bs-popper="static">

                                            <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('ads-sort-value').value=1; document.getElementById('ads-sort-form').submit();">
                                                {{ __('Preço mais baixo') }}
                                            </a>

                                            <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('ads-sort-value').value=2; document.getElementById('ads-sort-form').submit();">
                                                {{ __('Preço mais alto') }}
                                            </a>

                                            <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('ads-sort-value').value=3; document.getElementById('ads-sort-form').submit();">
                                                {{ __('Mais recente') }}
                                            </a>

                                            <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('ads-sort-value').value=4; document.getElementById('ads-sort-form').submit();">
                                                {{ __('Mais antigo') }}
                                            </a>

                                            <form id="ads-sort-form" action="{{ route('ads.sort') }}" method="POST" class="d-none">
                                                @csrf
                                                <input id="ads-sort-value" type="text" name="sort">
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>

                <div class="card-body" style="text-align: center; padding: 0px;">
                    @foreach($ads as $ad)
                    <a class="card" href="{{ route('ad') }}?adId={{ $ad->id }}" style="width: 30%; min-height: 300px; display: inline-block; vertical-align: top; margin: 10px; text-decoration: none; color: gray;">
                        <div class="card-header">{{ $ad->nome }}</div>

                        <div class="card-body">
                            <img src="{{ Photo::GetAd($ad->imageId) }}" style="max-width: 100%;"/>
                            <span>{{ $ad->descricao }}</span>
                        </div>

                        <div class="card-header">{{ ('Preço:') }} {{ $ad->preco }} {{ ('€') }}</div>
                    </a>
                    @endforeach
                    
                    @if ($ads->isEmpty())
                        <div class="card-header">{{ __('Não existem anuncios') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>