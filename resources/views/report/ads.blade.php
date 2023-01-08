@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="padding-top: 4px;padding-bottom: 4px;">
                    <nav class="navbar navbar-expand-md .navbar-light justify-content-between" style="padding-top: 0px;padding-bottom: 0px;">
                        <div class="container">
                            <span>{{ __('Os meus anuncios') }}</span>
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

                        <div class="card-header">{{ __('Preço:') }} {{ $ad->preco }}</div>
                        <div class="card-header">{{ __('Quantidade:') }} {{ $ad->quantidade }}</div>
                        <div class="card-header">{{ __('Disponivel:') }} 
                            @if($ad->disponivel == null || $ad->disponivel == "")
                                {{ $ad->quantidade }}
                            @else
                                {{ $ad->disponivel }}
                            @endif
                        </div>
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
@endsection
