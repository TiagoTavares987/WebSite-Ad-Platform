@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="padding-top: 4px;padding-bottom: 4px;">
                    <nav class="navbar navbar-expand-md .navbar-light justify-content-between" style="padding-top: 0px;padding-bottom: 0px;">
                        <div class="container">
                            <span>{{ $ad->nome }}</span>

                            @if(auth()->check() && (auth()->user()->is_admin || $ad->vendedorId == auth()->user()->id))
                            <div id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true" v-pre="">
                                            <img src="{{ asset('storage/images/edit.png') }}" width="20" height="20">
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" data-bs-popper="static">

                                        <a class="dropdown-item" href="{{ route('ad.edit') }}?adId={{ $ad->id }}">
                                                {{ __('Editar') }}
                                        </a>

                                        <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('ad-form-delete').submit();">
                                            {{ __('Apagar') }}
                                        </a>

                                        <form id="ad-form-delete" action="{{ route('ad.delete') }}" method="POST" class="d-none">
                                            @csrf
                                            <input type="text" name="adId" value="{{ $ad->id }}">
                                        </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            @endif

                        </div>
                    </nav>
                </div>

                @error('error')
                <div class="card-header">
                    <span style="color:red">{{ $message }}</span>
                </div>
                @enderror

                <div class="card-body">
                    <img src="{{ Photo::GetAd($ad->imageId) }}" style="max-width: 100%;"/>
                    <span>{{ $ad->descricao }}</span>
                </div>

                <div class="card-header">
                    <span>{{ __('Preco:') }} {{ $ad->preco }}</span>
                    <span>{{ __('Disponivel:') }} 
                        @if($ad->disponivel == null || $ad->disponivel == "")
                            {{ $ad->quantidade }}
                        @else
                            {{ $ad->disponivel }}
                        @endif
                    </span>                    
                </div>
                <div class="card-header">
                    @guest
                        <input size="4" value="1" disabled/> 
                        <button type="button" class="btn btn-success" style="border-radius: 25px; width: 50px; height: 50px;" disabled>+</button>
                        <button type="button" class="btn btn-danger" style="border-radius: 25px; width: 50px; height: 50px;" disabled>-</button>
                        <button type="button" class="btn btn-primary" style="border-radius: 25px; width: 50px; height: 50px; padding: 0;" disabled>
                            <img src="{{ asset('storage/images/shop_cart.png') }}" width="30px"/>
                        </button>
                    @else

                    @if($ad->vendedorId != Auth()->user()->id 
                        && (($ad->disponivel > 0 && $ad->disponivel != null && $ad->disponivel != "")
                            || ($ad->quantidade > 0 && ($ad->disponivel == null || $ad->disponivel == ""))))
                        <form action="{{ route('payment') }}" method="POST">
                            @csrf

                            <input name="adId" type="hidden" value="{{ $ad->id }}"/>
                            <input name="price" type="hidden" value="{{ $ad->preco }}"/>
                            <input id="buy_quantity" name="quantity" type="text" size="4" value="1"/> 
                            <button type="button" class="btn btn-success" style="border-radius: 25px; width: 50px; height: 50px;" onclick="var val = parseFloat(document.getElementById('buy_quantity').value) + 1; if(val <= {{ $ad->quantidade }}) document.getElementById('buy_quantity').value=val;">+</button>
                            <button type="button" class="btn btn-danger" style="border-radius: 25px; width: 50px; height: 50px;" onclick="var val = parseFloat(document.getElementById('buy_quantity').value) - 1; if(val > 0) document.getElementById('buy_quantity').value=val;">-</button>
                            <button type="submit" class="btn btn-primary" style="border-radius: 25px; width: 50px; height: 50px; padding: 0;">
                                <img src="{{ asset('storage/images/shop_cart.png') }}" width="30px"/>
                            </button>
                        </form>
                    @endif    
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
